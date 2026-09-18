<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

use App\Models\Employee;
use App\Models\Cycle;
use App\Models\ExportEmployee;
use App\Services\ExportEmployeeBuilder;
use App\Services\AssessmentScoreCalculator;

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;

class EmployeeImportController extends Controller
{
    protected int $batchSize = 300;

    public function showForm()
    {
        return view('employees.import');
    }

    public function importAppend(Request $request, ExportEmployeeBuilder $builder, AssessmentScoreCalculator $calculator)
    {
        return $this->handleImport($request, 'append', $builder, $calculator);
    }

    public function importReplace(Request $request, ExportEmployeeBuilder $builder, AssessmentScoreCalculator $calculator)
    {
        return $this->handleImport($request, 'replace', $builder, $calculator);
    }

    protected function activeCycleOrLatest(): ?Cycle
    {
        if (!Schema::hasTable('cycles')) return null;

        if (Schema::hasColumn('cycles', 'is_active')) {
            $active = Cycle::query()->where('is_active', true)->orderByDesc('id')->first();
            if ($active) return $active;
        }

        if (Schema::hasColumn('cycles', 'status') && defined(Cycle::class . '::STATUS_OPEN')) {
            $open = Cycle::query()->where('status', Cycle::STATUS_OPEN)->orderByDesc('id')->first();
            if ($open) return $open;
        }

        return Cycle::query()->orderByDesc('id')->first();
    }

    protected function handleImport(Request $request, string $mode, ExportEmployeeBuilder $builder, AssessmentScoreCalculator $calculator)
    {
        @ini_set('memory_limit', '1024M');
        @set_time_limit(0);
        DB::disableQueryLog();

        $request->validate(
            [
                'files'   => ['required', 'array'],
                'files.*' => ['file', 'mimes:xlsx,xls,csv', 'max:51200'],
            ],
            [
                'files.required'   => __('app.emp_import_error_file_required'),
                'files.array'      => __('app.emp_import_error_file_invalid'),
                'files.*.file'     => __('app.emp_import_error_file_invalid'),
                'files.*.mimes'    => __('app.emp_import_error_file_mime'),
                'files.*.max'      => __('app.emp_import_error_file_max'),
            ]
        );

        $files = $request->file('files', []);
        if (!is_array($files)) $files = [$files];
        $files = array_values(array_filter($files));

        if (count($files) === 0) {
            return back()->with('error', __('app.emp_import_error_file_required'))->withInput();
        }

        if (!Schema::hasTable('employees')) {
            return back()->with('error', 'employees table not found')->withInput();
        }

        $empCols   = Schema::getColumnListing('employees');
        $empColSet = [];
        foreach ($empCols as $c) $empColSet[$c] = true;

        $empHasCreatedAt  = isset($empColSet['created_at']);
        $empHasUpdatedAt  = isset($empColSet['updated_at']);
        $empHasTimestamps = $empHasCreatedAt && $empHasUpdatedAt;

        $idField = null;
        if (isset($empColSet['citizen_id'])) $idField = 'citizen_id';
        elseif (isset($empColSet['id_thai_hash'])) $idField = 'id_thai_hash';

        $pbTableExists = Schema::hasTable('pb_employee_scores');
        $pbHasPosition   = $pbTableExists ? Schema::hasColumn('pb_employee_scores', 'position') : false;
        $pbHasDeptQms    = $pbTableExists ? Schema::hasColumn('pb_employee_scores', 'dept_abbr_qms') : false;
        $pbHasCreatedAt  = $pbTableExists ? Schema::hasColumn('pb_employee_scores', 'created_at') : false;
        $pbHasUpdatedAt  = $pbTableExists ? Schema::hasColumn('pb_employee_scores', 'updated_at') : false;
        $pbHasTimestamps = $pbHasCreatedAt && $pbHasUpdatedAt;

        $pbUpdateCols = [];
        if ($pbHasPosition)  $pbUpdateCols[] = 'position';
        if ($pbHasDeptQms)   $pbUpdateCols[] = 'dept_abbr_qms';
        if ($pbHasUpdatedAt) $pbUpdateCols[] = 'updated_at';

        $appTableExists = Schema::hasTable('app_users');
        $appHasUsername = $appTableExists ? Schema::hasColumn('app_users', 'username') : false;
        $appHasRole     = $appTableExists ? Schema::hasColumn('app_users', 'role') : false;
        $appHasPassword = $appTableExists ? Schema::hasColumn('app_users', 'password') : false;
        $appHasIdHash   = $appTableExists ? Schema::hasColumn('app_users', 'id_thai_hash') : false;
        $appHasCreatedAt = $appTableExists ? Schema::hasColumn('app_users', 'created_at') : false;
        $appHasUpdatedAt = $appTableExists ? Schema::hasColumn('app_users', 'updated_at') : false;
        $appHasTimestamps = $appHasCreatedAt && $appHasUpdatedAt;

        if ($mode === 'replace') {
            Employee::query()->delete();
        }

        $now = now();

        foreach ($files as $file) {
            if (!$file || !$file->isValid()) {
                return back()->with('error', __('app.emp_import_error_file_invalid'))->withInput();
            }

            try {
                $reader = IOFactory::createReaderForFile($file->getRealPath());
                $reader->setReadDataOnly(true);
                if (method_exists($reader, 'setReadEmptyCells')) $reader->setReadEmptyCells(false);
                $spreadsheet = $reader->load($file->getRealPath());
            } catch (\Throwable $e) {
                Log::error('Employee import: read excel fail', ['message' => $e->getMessage()]);
                return back()->with('error', __('app.emp_import_error_read'))->withInput();
            }

            $sheet = $spreadsheet->getActiveSheet();

            $colCap = 120;
            $capLetter = Coordinate::stringFromColumnIndex($colCap);

            $highestRow = (int) $sheet->getHighestDataRow('A');
            if ($highestRow < 3) {
                try { $spreadsheet->disconnectWorksheets(); } catch (\Throwable $e) {}
                unset($spreadsheet);
                gc_collect_cycles();
                return back()->with('error', __('app.emp_import_error_no_data'))->withInput();
            }

            $headerRange = 'A2:' . $capLetter . '2';
            $headerRow = $sheet->rangeToArray($headerRange, null, false, false, false);
            $header = $headerRow[0] ?? [];

            $lastHeaderIdx = 0;
            for ($i = count($header) - 1; $i >= 0; $i--) {
                if ($this->hasValue($header[$i] ?? null)) { $lastHeaderIdx = $i; break; }
            }

            $headerIndex = $this->buildHeaderIndex($header);

            $codeIdx = $this->findEmployeeCodeIndex($headerIndex);
            $stringMapFallback = $this->makeStringMapFallback($codeIdx);

            $idIdx = $this->findCitizenIdIndex($headerIndex);
            $stringMap = $this->buildStringMap($headerIndex, $stringMapFallback, $idIdx, $idField);

            $numMap = [];
            foreach ($header as $index => $title) {
                $norm = $this->normalizeHeader($title);
                if ($norm === '') continue;

                switch ($norm) {
                    case 'รวม': $numMap['attendance_total'] = $index; break;
                    case 'ป่วย': $numMap['attendance_sick'] = $index; break;
                    case 'ลากิจ': $numMap['attendance_personal'] = $index; break;
                    case 'ลาคลอด': $numMap['attendance_maternity'] = $index; break;
                    case 'บวช': $numMap['attendance_ordain'] = $index; break;
                    case 'มาสาย': $numMap['attendance_late'] = $index; break;
                    case 'ขาดงาน': $numMap['attendance_absent'] = $index; break;
                    case 'หนังสือเตือน': $numMap['attendance_warning'] = $index; break;
                    case 'พักงาน': $numMap['attendance_suspension'] = $index; break;

                    case 'teamwork':
                    case 'team work':
                    case 'teamwork score':
                    case 'team work score':
                        $numMap['score_teamwork'] = $index; break;

                    case 'communication':
                    case 'communication skill':
                    case 'communication score':
                        $numMap['score_communication'] = $index; break;

                    case 'leadership':
                    case 'leader':
                    case 'leadership score':
                    case 'leader score':
                    case 'ภาวะผู้นำ':
                    case 'คะแนนภาวะผู้นำ':
                        $numMap['score_leadership'] = $index; break;

                    case 'attitude':
                    case 'attitude score':
                    case 'attritude':
                    case 'attritude score':
                    case 'attitute':
                    case 'attitute score':
                    case 'ทัศนคติ':
                    case 'คะแนนทัศนคติ':
                        $numMap['score_attitude'] = $index; break;

                    case 'planning/proactivity':
                    case 'planning&proactivity':
                    case 'planning and proactivity':
                    case 'planning proactivity':
                    case 'planning-proactivity':
                        $numMap['score_planning'] = $index; break;

                    case 'problem solving':
                    case 'problem-solving':
                    case 'problemsolving':
                    case 'problem solving score':
                        $numMap['score_problem_solving'] = $index; break;

                    case 'ownership/responsibility':
                    case 'ownership&responsibility':
                    case 'ownership and responsibility':
                    case 'ownership responsibility':
                    case 'ownership-responsibility':
                        $numMap['score_ownership'] = $index; break;

                    case 'department level okr score':
                    case 'department okr score':
                    case 'dept okr score':
                    case 'dept okr':
                    case 'department okr':
                        $numMap['score_dept_okr'] = $index; break;

                    case 'company level okr score':
                    case 'company okr score':
                    case 'company okr':
                    case 'company okr score(%)':
                        $numMap['score_company_okr'] = $index; break;

                    case 'okr-reporting score':
                    case 'okr reporting score':
                    case 'okr reporting':
                    case 'okr - reporting score':
                    case 'okr -reporting score':
                    case 'okr- reporting score':
                        $numMap['score_okr_reporting'] = $index; break;

                    case 'system(smbr)':
                    case 'system smbr':
                    case 'smbr':
                    case 'system(smbr) score':
                        $numMap['score_system_smbr'] = $index; break;

                    case 'bonus score':
                    case 'bonus':
                        $numMap['score_bonus'] = $index; break;

                    case 'leadership(division)':
                    case 'leadership (division)':
                    case 'attitude(division)':
                    case 'attitude (division)':
                        if (str_starts_with($norm, 'leadership')) $numMap['division_score_leadership'] = $index;
                        else $numMap['division_score_attitude'] = $index;
                        break;

                    case 'division_score_leadership':
                    case 'division leadership':
                    case 'division leadership score':
                    case 'division leader score':
                    case 'ภาวะผู้นำ(division)':
                    case 'คะแนนภาวะผู้นำ(division)':
                    case 'ภาวะผู้นำ (division)':
                    case 'คะแนนภาวะผู้นำ (division)':
                        $numMap['division_score_leadership'] = $index; break;

                    case 'division_score_attitude':
                    case 'division attitude':
                    case 'division attitude score':
                    case 'division attritude':
                    case 'division attritude score':
                    case 'ทัศนคติ(division)':
                    case 'คะแนนทัศนคติ(division)':
                    case 'ทัศนคติ (division)':
                    case 'คะแนนทัศนคติ (division)':
                        $numMap['division_score_attitude'] = $index; break;
                }
            }

            $needIdx = $lastHeaderIdx;
            $needIdx = max($needIdx, $codeIdx);

            foreach ($stringMap as $idx) {
                if ($idx !== null) $needIdx = max($needIdx, (int)$idx);
            }
            foreach ($numMap as $idx) {
                $needIdx = max($needIdx, (int)$idx);
            }

            $needColIndex = min($colCap, $needIdx + 1);
            if ($needColIndex < 1) $needColIndex = 1;

            $dataEndLetter = Coordinate::stringFromColumnIndex($needColIndex);
            $maxIdx = $needColIndex - 1;

            $batch = [];
            $readChunk = 400;

            for ($start = 3; $start <= $highestRow; $start += $readChunk) {
                $end = min($highestRow, $start + $readChunk - 1);

                $dataRange = 'A' . $start . ':' . $dataEndLetter . $end;
                $dataRows = $sheet->rangeToArray($dataRange, null, false, false, false);

                foreach ($dataRows as $cells) {
                    if (!is_array($cells)) continue;

                    $rawCode = $cells[$codeIdx] ?? null;
                    $employeeCode = $this->digitsOnly($this->toString($rawCode));

                    if ($employeeCode === '' || strlen($employeeCode) < 4) {
                        $candidate = '';
                        $probeMax = min($maxIdx, 6);
                        for ($ci = 0; $ci <= $probeMax; $ci++) {
                            if ($ci === $codeIdx) continue;
                            $cand = $this->digitsOnly($this->toString($cells[$ci] ?? null));
                            if ($cand !== '' && strlen($cand) >= 4) { $candidate = $cand; break; }
                        }
                        if ($candidate !== '') $employeeCode = $candidate;
                    }

                    if ($employeeCode === '') continue;

                    $row = [
                        'employee_code' => $employeeCode,
                        'values' => [],
                        '_has'   => [],
                    ];

                    foreach ($stringMap as $field => $index) {
                        if ($index === null) continue;
                        $idx = (int)$index;
                        if ($idx < 0 || $idx > $maxIdx) continue;

                        $raw = $cells[$idx] ?? null;

                        if ($idField && $field === $idField) {
                            $norm = $this->normalizeCitizenId($raw);
                            if ($norm !== null) {
                                $row['values'][$idField] = $norm;
                                $row['_has'][$idField] = true;
                            } else {
                                $row['values'][$idField] = null;
                            }
                            continue;
                        }

                        if ($this->hasValue($raw)) {
                            $row['values'][$field] = $this->toString($raw);
                            $row['_has'][$field] = true;
                        } else {
                            $row['values'][$field] = null;
                        }
                    }

                    foreach ($numMap as $field => $index) {
                        $idx = (int)$index;
                        if ($idx < 0 || $idx > $maxIdx) continue;

                        $raw = $cells[$idx] ?? null;
                        if ($this->hasValue($raw)) {
                            $row['values'][$field] = $this->toDecimalOrNull($raw, 2);
                            $row['_has'][$field] = true;
                        } else {
                            $row['values'][$field] = null;
                        }
                    }

                    $batch[] = $row;

                    if (count($batch) >= $this->batchSize) {
                        $this->flushBatch(
                            $batch,
                            $mode,
                            $empColSet,
                            $empHasTimestamps,
                            $empHasCreatedAt,
                            $empHasUpdatedAt,
                            $now,
                            $pbTableExists,
                            $pbHasPosition,
                            $pbHasDeptQms,
                            $pbHasTimestamps,
                            $pbHasUpdatedAt,
                            $pbUpdateCols,
                            $appTableExists,
                            $appHasUsername,
                            $appHasRole,
                            $appHasPassword,
                            $appHasIdHash,
                            $appHasTimestamps,
                            $appHasUpdatedAt,
                            $idField
                        );
                        $batch = [];
                    }
                }

                unset($dataRows);
                gc_collect_cycles();
            }

            if (!empty($batch)) {
                $this->flushBatch(
                    $batch,
                    $mode,
                    $empColSet,
                    $empHasTimestamps,
                    $empHasCreatedAt,
                    $empHasUpdatedAt,
                    $now,
                    $pbTableExists,
                    $pbHasPosition,
                    $pbHasDeptQms,
                    $pbHasTimestamps,
                    $pbHasUpdatedAt,
                    $pbUpdateCols,
                    $appTableExists,
                    $appHasUsername,
                    $appHasRole,
                    $appHasPassword,
                    $appHasIdHash,
                    $appHasTimestamps,
                    $appHasUpdatedAt,
                    $idField
                );
            }

            try { $spreadsheet->disconnectWorksheets(); } catch (\Throwable $e) {}
            unset($spreadsheet);
            gc_collect_cycles();
        }

        $cycle = $this->activeCycleOrLatest();
        $cycleId = $cycle?->id;

        if ($cycleId && Schema::hasTable('export_employees')) {
            if (method_exists($builder, 'syncAllEmployeesInCycle')) {
                $builder->syncAllEmployeesInCycle((int)$cycleId, true);
            } elseif (method_exists($builder, 'syncAndComputeAllEmployeesInCycle')) {
                $builder->syncAndComputeAllEmployeesInCycle((int)$cycleId, true);
            }

            $calculator->computeAllInCycle((int)$cycleId);
        }

        $msgKey = $mode === 'replace' ? 'emp_import_success_replace' : 'emp_import_success_append';
        return back()->with('success', __('app.' . $msgKey));
    }

    protected function flushBatch(
        array $batch,
        string $mode,
        array $empColSet,
        bool $empHasTimestamps,
        bool $empHasCreatedAt,
        bool $empHasUpdatedAt,
        $now,
        bool $pbTableExists,
        bool $pbHasPosition,
        bool $pbHasDeptQms,
        bool $pbHasTimestamps,
        bool $pbHasUpdatedAt,
        array $pbUpdateCols,
        bool $appTableExists,
        bool $appHasUsername,
        bool $appHasRole,
        bool $appHasPassword,
        bool $appHasIdHash,
        bool $appHasTimestamps,
        bool $appHasUpdatedAt,
        ?string $idField
    ): void {
        if (empty($batch)) return;

        $codes = array_values(array_unique(array_map(fn($r) => (string)($r['employee_code'] ?? ''), $batch)));
        $codes = array_values(array_filter($codes, fn($c) => $c !== ''));
        if (!$codes) return;

        $existingEmpMap = collect();
        if ($mode !== 'replace') {
            $selectCols = ['employee_code'];

            $maybeCols = array_merge(
                array_keys($batch[0]['values'] ?? []),
                ['position_level', 'assessment_status', 'sup_id', 'div_mgr_id']
            );

            foreach ($maybeCols as $c) {
                if (isset($empColSet[$c])) $selectCols[] = $c;
            }

            $selectCols = array_values(array_unique($selectCols));

            try {
                $existingEmpMap = DB::table('employees')
                    ->whereIn('employee_code', $codes)
                    ->get($selectCols)
                    ->keyBy('employee_code');
            } catch (\Throwable $e) {
                $existingEmpMap = collect();
            }
        }

        $rows = [];
        $hasPositionLevel    = isset($empColSet['position_level']);
        $hasAssessmentStatus = isset($empColSet['assessment_status']);

        foreach ($batch as $item) {
            $code = (string)($item['employee_code'] ?? '');
            if ($code === '') continue;

            $vals = (array)($item['values'] ?? []);
            $has  = (array)($item['_has'] ?? []);
            $existing = $existingEmpMap->get($code);

            $row = ['employee_code' => $code];

            foreach ($vals as $field => $value) {
                if (!isset($empColSet[$field])) continue;

                if ($mode !== 'replace' && $existing && $value === null) {
                    $row[$field] = $existing->{$field} ?? null;
                } else {
                    $row[$field] = $value;
                }
            }

            if ($hasPositionLevel) {
                $pos = $row['position'] ?? ($existing->position ?? null);

                $lvl = null;
                if ($pos !== null && trim((string)$pos) !== '') {
                    $lvl = $this->detectPositionLevel((string)$pos);
                }

                $row['position_level'] = $lvl ?? ($existing->position_level ?? null);
            }

            if ($hasAssessmentStatus) {
                $sup = (string)($row['sup_id'] ?? ($existing->sup_id ?? ''));
                $div = (string)($row['div_mgr_id'] ?? ($existing->div_mgr_id ?? ''));

                $supCode = $this->digitsOnly($sup);
                $divCode = $this->digitsOnly($div);

                $shouldRecalc = (!$existing) || isset($has['sup_id']) || isset($has['div_mgr_id']);

                if ($shouldRecalc) {
                    $lvl = null;
                    if ($hasPositionLevel && isset($row['position_level']) && $row['position_level'] !== null && $row['position_level'] !== '') {
                        $lvl = (int)$row['position_level'];
                    }

                    if ($lvl !== null && $lvl >= 6) {
                        $row['assessment_status'] = '0/0';
                    } else {
                        $required = ($divCode !== '' && $divCode !== $supCode) ? 2 : 1;
                        $row['assessment_status'] = '0/' . $required;
                    }
                } elseif ($existing) {
                    $row['assessment_status'] = $existing->assessment_status ?? ($row['assessment_status'] ?? null);
                }
            }

            if ($empHasTimestamps) {
                $row['updated_at'] = $now;
                $row['created_at'] = $now;
            } elseif ($empHasUpdatedAt) {
                $row['updated_at'] = $now;
            }

            $rows[] = $row;
        }

        if (!$rows) return;

        $updateCols = array_keys($rows[0]);
        $updateCols = array_values(array_filter($updateCols, fn($c) => $c !== 'employee_code' && $c !== 'created_at'));

        DB::transaction(function () use (
            $rows,
            $codes,
            $updateCols,
            $now,
            $pbTableExists,
            $pbHasPosition,
            $pbHasDeptQms,
            $pbHasTimestamps,
            $pbHasUpdatedAt,
            $pbUpdateCols,
            $appTableExists,
            $appHasUsername,
            $appHasRole,
            $appHasPassword,
            $appHasIdHash,
            $appHasTimestamps,
            $appHasUpdatedAt,
            $idField
        ) {
            DB::table('employees')->upsert($rows, ['employee_code'], $updateCols);

            if ($pbTableExists) {
                $pbExisting = collect();
                try {
                    $sel = ['employee_code'];
                    if ($pbHasPosition) $sel[] = 'position';
                    if ($pbHasDeptQms) $sel[] = 'dept_abbr_qms';

                    $pbExisting = DB::table('pb_employee_scores')
                        ->whereIn('employee_code', $codes)
                        ->get($sel)
                        ->keyBy('employee_code');
                } catch (\Throwable $e) {
                    $pbExisting = collect();
                }

                $pbRows = [];
                foreach ($rows as $er) {
                    $code = $er['employee_code'] ?? null;
                    if (!$code) continue;

                    $exist = $pbExisting->get($code);

                    $pos  = $er['position'] ?? null;
                    $dept = $er['dept_abbr_qms'] ?? null;

                    if ($exist) {
                        if ($pos === null && $pbHasPosition) $pos = $exist->position ?? null;
                        if ($dept === null && $pbHasDeptQms) $dept = $exist->dept_abbr_qms ?? null;
                    }

                    $pbRow = [
                        'employee_code' => $code,
                        'net_score'     => 100,
                    ];

                    if ($pbHasPosition) $pbRow['position'] = $this->cleanText($pos ?? '') ?: null;
                    if ($pbHasDeptQms)  $pbRow['dept_abbr_qms'] = $this->cleanText($dept ?? '') ?: null;

                    if ($pbHasTimestamps) {
                        $pbRow['created_at'] = $now;
                        $pbRow['updated_at'] = $now;
                    } elseif ($pbHasUpdatedAt) {
                        $pbRow['updated_at'] = $now;
                    }

                    $pbRows[] = $pbRow;
                }

                if ($pbRows) {
                    $this->upsertPbScores($pbRows, $pbUpdateCols);
                }
            }

            if ($idField && $appTableExists && $appHasUsername) {
                $idMap = [];
                foreach ($rows as $er) {
                    if (!empty($er[$idField])) {
                        $idMap[(string)$er['employee_code']] = (string)$er[$idField];
                    }
                }

                if ($idMap) {
                    $userCodes = array_keys($idMap);

                    $existingUsers = collect();
                    try {
                        $sel = ['username'];
                        if ($appHasRole) $sel[] = 'role';
                        if ($appHasPassword) $sel[] = 'password';
                        if ($appHasIdHash) $sel[] = 'id_thai_hash';

                        $existingUsers = DB::table('app_users')
                            ->whereIn('username', $userCodes)
                            ->get($sel)
                            ->keyBy('username');
                    } catch (\Throwable $e) {
                        $existingUsers = collect();
                    }

                    $ins = [];
                    $updates = [];

                    foreach ($idMap as $code => $idValue) {
                        $u = $existingUsers->get($code);

                        if (!$u) {
                            $row = ['username' => $code];

                            if ($appHasRole) $row['role'] = 'user';

                            if ($appHasIdHash) $row['id_thai_hash'] = $idValue;
                            if ($appHasPassword) $row['password'] = $idValue;

                            if ($appHasTimestamps) {
                                $row['created_at'] = $now;
                                $row['updated_at'] = $now;
                            } elseif ($appHasUpdatedAt) {
                                $row['updated_at'] = $now;
                            }

                            $ins[] = $row;
                            continue;
                        }

                        $needSet = ($appHasIdHash && empty($u->id_thai_hash)) || ($appHasPassword && empty($u->password));
                        $upd = [];

                        if ($needSet) {
                            if ($appHasIdHash && empty($u->id_thai_hash)) $upd['id_thai_hash'] = $idValue;
                            if ($appHasPassword && empty($u->password)) $upd['password'] = $idValue;
                        }

                        if ($upd) {
                            if ($appHasUpdatedAt) $upd['updated_at'] = $now;
                            $updates[$code] = $upd;
                        }
                    }

                    if ($ins) {
                        try { DB::table('app_users')->insertOrIgnore($ins); } catch (\Throwable $e) {}
                    }

                    if ($updates) {
                        foreach ($updates as $code => $upd) {
                            try { DB::table('app_users')->where('username', $code)->update($upd); } catch (\Throwable $e) {}
                        }
                    }
                }
            }
        });
    }

    protected function upsertPbScores(array $rows, array $updateCols): void
    {
        if (!$rows) return;
        if (!Schema::hasTable('pb_employee_scores')) return;

        if (empty($updateCols)) {
            DB::table('pb_employee_scores')->insertOrIgnore($rows);
            return;
        }

        DB::table('pb_employee_scores')->upsert($rows, ['employee_code'], $updateCols);
    }

    protected function digitsOnly($v): string
    {
        $s = (string)($v ?? '');
        $s = preg_replace('/\D/', '', $s);
        return $s ?: '';
    }

    protected function detectPositionLevel(string $position): ?int
    {
        $p = trim(mb_strtolower($position, 'UTF-8'));
        if ($p === '') return null;

        $p = preg_replace('/\s+/u', ' ', $p);
        $p = str_replace(['.', ',', '(', ')', '/', '\\'], ' ', $p);
        $p = preg_replace('/\s+/u', ' ', $p);
        $p = trim($p);

        $map = [
            1 => ['cooking','driver','maid','operator','senior operator','support mat','tp man'],
            2 => ['foreman','leader','senior staff','senior technician','staff','technician'],
            3 => ['engineer','senior engineer','supervisor'],
            4 => ['assist manager','assistant manager','manager'],
            5 => ['deputy general manager','general manager','gm'],
            6 => ['chief financial officer','cfo'],
            7 => ['chief executive officer','ceo'],
            8 => ['president'],
        ];

        foreach ($map as $lvl => $keys) {
            foreach ($keys as $k) {
                if ($p === $k) return $lvl;
                if (str_contains($p, $k)) return $lvl;
            }
        }

        return null;
    }

    protected function buildHeaderIndex(array $header): array
    {
        $index = [];
        foreach ($header as $i => $title) {
            $norm = $this->normalizeHeader($title);
            if ($norm === '') continue;
            $index[$norm] = $i;
        }
        return $index;
    }

    protected function findEmployeeCodeIndex(array $headerIndex): int
    {
        $candidates = [
            'รหัสพนักงาน',
            'employee_code',
            'employee code',
            'emp code',
            'emp_code',
            'code',
        ];

        foreach ($candidates as $key) {
            $k = $this->normalizeHeader($key);
            if (array_key_exists($k, $headerIndex)) {
                return (int) $headerIndex[$k];
            }
        }

        return 0;
    }

    protected function makeStringMapFallback(int $codeIdx): array
    {
        $base = $codeIdx + 1;

        return [
            'full_name_th'   => $base + 0,
            'full_name_en'   => $base + 1,
            'employee_type'  => $base + 2,
            'position'       => $base + 3,
            'department'     => $base + 4,
            'dept_abbr_qms'  => $base + 5,
            'dept_abbr_hr'   => $base + 6,
            'sup_id'         => $base + 7,
            'sup_name'       => $base + 8,
            'div_mgr_id'     => $base + 9,
            'div_mgr_name'   => $base + 10,
            'dept_mgr_id'    => $base + 11,
            'dept_mgr_name'  => $base + 12,
            'plant_mgr_id'   => $base + 13,
            'plant_mgr_name' => $base + 14,
        ];
    }

    protected function findCitizenIdIndex(array $headerIndex): ?int
    {
        $candidates = [
            'เลขที่ประกันสังคม','เลขประกันสังคม','ประกันสังคม','social security','social security no','ssn',
            'เลขบัตรประชาชน','เลขบัตร','citizen_id','citizen id','national id','national_id','id card','id_card','thai id','thai_id',
            'id_thai_hash','id thai hash','thai hash','thai_id_hash',
        ];

        foreach ($candidates as $key) {
            $k = $this->normalizeHeader($key);
            if (array_key_exists($k, $headerIndex)) {
                return (int) $headerIndex[$k];
            }
        }
        return null;
    }

    protected function buildStringMap(array $headerIndex, array $fallback, ?int $idIdx, ?string $idField): array
    {
        $map = [];

        if ($idIdx !== null && $idField) {
            $map[$idField] = $idIdx;
        }

        $aliases = [
            'full_name_th'   => ['ชื่อ-สกุล(ไทย)', 'ชื่อไทย', 'full_name_th', 'fullname_th'],
            'full_name_en'   => ['ชื่อ-สกุล(eng)', 'ชื่อ-สกุล(eng.)', 'ชื่ออังกฤษ', 'full_name_en', 'fullname_en'],
            'employee_type'  => ['ประเภท', 'employee_type', 'type'],
            'position'       => ['ตำแหน่ง', 'position'],
            'department'     => ['แผนก/ฝ่าย', 'แผนก', 'department'],
            'dept_abbr_qms'  => ['ตัวย่อแผนก (ใช้ใน qms)', 'dept_abbr_qms', 'abbr_qms', 'qms'],
            'dept_abbr_hr'   => ['ตัวย่อส่วนงาน (ใช้ใน hr)', 'dept_abbr_hr', 'abbr_hr', 'hr'],

            'sup_id'         => ['id supervisor', 'sup_id', 'supervisor id'],
            'sup_name'       => ['supervisor name', 'sup_name', 'ชื่อ supervisor'],

            'div_mgr_id'     => ['id division manager', 'div_mgr_id', 'division manager id'],
            'div_mgr_name'   => ['division manager name', 'div_mgr_name'],

            'dept_mgr_id'    => ['id dept.mgr', 'dept_mgr_id', 'dept manager id'],
            'dept_mgr_name'  => ['dept.mgr name', 'dept_mgr_name', 'dept manager name'],

            'plant_mgr_id'   => ['id plant mgr', 'plant_mgr_id', 'plant manager id'],
            'plant_mgr_name' => ['plant manager name', 'plant_mgr_name'],
        ];

        foreach ($aliases as $field => $keys) {
            $found = null;

            foreach ($keys as $k) {
                $nk = $this->normalizeHeader($k);
                if (array_key_exists($nk, $headerIndex)) {
                    $found = (int) $headerIndex[$nk];
                    break;
                }
            }

            if ($found !== null) {
                $map[$field] = $found;
            } elseif (array_key_exists($field, $fallback)) {
                $map[$field] = $fallback[$field];
            }
        }

        return $map;
    }

    protected function isExcelNA($value): bool
    {
        if ($value === null) return true;

        $s = trim((string) $value);
        if ($s === '') return true;

        if (str_contains($s, '####')) return true;

        $u = strtoupper($s);
        $u = preg_replace('/\s+/u', '', $u) ?? $u;

        return in_array($u, [
            'N/A', 'NA', 'N\\A',
            '#N/A', '#N/A!', '#NA', '#VALUE!',
            'NULL', 'NONE',
            '-', '--',
        ], true);
    }

    protected function hasValue($value): bool
    {
        return !$this->isExcelNA($value);
    }

    protected function toString($value): ?string
    {
        if ($value === null) return null;

        if (is_int($value)) {
            return (string) $value;
        }

        if (is_float($value)) {
            if (abs($value - round($value)) < 0.0000001) {
                return sprintf('%.0f', $value);
            }
            $s = rtrim(rtrim(sprintf('%.10F', $value), '0'), '.');
            return $s === '' ? null : $s;
        }

        $str = trim((string) $value);
        if ($str === '' || $this->isExcelNA($str) || str_contains($str, '####')) return null;

        $str = preg_replace('/\s+/u', ' ', $str) ?? $str;

        $compact = str_replace([',', ' '], '', $str);

        if (preg_match('/^\d+\.0+$/', $compact)) {
            return explode('.', $compact, 2)[0];
        }

        if ((stripos($compact, 'e') !== false) && is_numeric($compact)) {
            $f = (float) $compact;
            if (abs($f - round($f)) < 0.0000001) {
                return sprintf('%.0f', $f);
            }
            $s = rtrim(rtrim(sprintf('%.10F', $f), '0'), '.');
            return $s === '' ? null : $s;
        }

        return $str;
    }

    protected function toDecimalOrNull($value, int $scale = 2): ?float
    {
        if ($this->isExcelNA($value)) return null;

        if (is_int($value) || is_float($value)) {
            return round((float) $value, $scale);
        }

        $s = trim((string) $value);
        if ($s === '' || $this->isExcelNA($s) || str_contains($s, '####')) return null;

        $s = $this->toArabicDigits($s);

        $raw = str_replace(' ', '', $s);

        if (preg_match('/^\d+,\d+$/', $raw) && !str_contains($raw, '.')) {
            $raw = str_replace(',', '.', $raw);
        } else {
            $raw = str_replace(',', '', $raw);
        }

        if (!is_numeric($raw)) return null;

        return round((float) $raw, $scale);
    }

    protected function normalizeHeader($value): string
    {
        if ($value === null) return '';

        $str = trim((string) $value);
        if ($str === '') return '';

        $str = preg_replace('/\s+/u', ' ', $str);

        if (function_exists('mb_strtolower')) {
            $str = mb_strtolower($str, 'UTF-8');
        } else {
            $str = strtolower($str);
        }

        $str = str_replace(["–", "—", "−"], "-", $str);
        $str = str_replace(["／", "\\"], "/", $str);

        $str = preg_replace('/\s*\/\s*/u', '/', $str);
        $str = preg_replace('/\s*-\s*/u', '-', $str);

        $str = preg_replace('/\s*\(\s*/u', '(', $str);
        $str = preg_replace('/\s*\)\s*/u', ')', $str);

        $str = preg_replace('/\s+/u', ' ', $str);

        return trim($str);
    }

    protected function toArabicDigits(string $s): string
    {
        $map = [
            '๐'=>'0','๑'=>'1','๒'=>'2','๓'=>'3','๔'=>'4','๕'=>'5','๖'=>'6','๗'=>'7','๘'=>'8','๙'=>'9',
            '໐'=>'0','໑'=>'1','໒'=>'2','໓'=>'3','໔'=>'4','໕'=>'5','໖'=>'6','໗'=>'7','໘'=>'8','໙'=>'9',
        ];
        return strtr($s, $map);
    }

    protected function normalizeCitizenId($v): ?string
    {
        if ($v === null) return null;

        if (is_float($v)) {
            $v = sprintf('%.0f', $v);
        } elseif (is_int($v)) {
            $v = (string) $v;
        }

        $v = trim((string) $v);
        if ($v === '' || str_contains($v, '#') || $this->isExcelNA($v)) return null;

        if (str_starts_with($v, 'eyJ')) return null;

        $compact = str_replace([' ', ','], '', $v);
        if (preg_match('/^\d+\.0+$/', $compact)) {
            $v = explode('.', $compact, 2)[0];
        }

        $v = $this->toArabicDigits($v);

        $digits = preg_replace('/\D+/', '', $v) ?? '';
        $digits = trim($digits);

        return $digits === '' ? null : $digits;
    }

    private function cleanText($v): string
    {
        $s = trim((string) $v);
        if ($s === '') return '';
        return trim(html_entity_decode($s, ENT_QUOTES | ENT_HTML5, 'UTF-8'));
    }
}
