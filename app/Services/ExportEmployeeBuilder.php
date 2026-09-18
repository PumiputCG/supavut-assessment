<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ExportEmployeeBuilder
{
    private array $colLenCache = [];

    public function clearExportTable(): void
    {
        $exportTable = $this->exportTableName();
        if (!$exportTable) return;
        DB::table($exportTable)->delete();
    }

    public function clearExportForCycle(int $cycleId): void
    {
        $exportTable = $this->exportTableName();
        if (!$exportTable) return;

        if (Schema::hasColumn($exportTable, 'cycle_id')) {
            DB::table($exportTable)->where('cycle_id', $cycleId)->delete();
        } else {
            DB::table($exportTable)->delete();
        }
    }

    public function archiveCycleToHistory(int $cycleId): void
    {
        $exportTable = $this->exportTableName();
        if (!$exportTable) return;

        if (!Schema::hasColumn($exportTable, 'cycle_id')) return;

        $historyTable = null;
        if (Schema::hasTable('export_employee_history')) $historyTable = 'export_employee_history';
        elseif (Schema::hasTable('export_employee_histories')) $historyTable = 'export_employee_histories';
        if (!$historyTable) return;

        if (!Schema::hasColumn($historyTable, 'cycle_id')) return;

        $histCols = Schema::getColumnListing($historyTable);

        $expCols = Schema::getColumnListing($exportTable);
        $expSet  = array_fill_keys($expCols, true);

        $now = now()->toDateTimeString();

        $insertCols = [];
        $selectExpr = [];

        foreach ($histCols as $c) {
            if ($c === 'id') continue;

            if (isset($expSet[$c])) {
                $insertCols[] = $c;
                $selectExpr[] = $c;
                continue;
            }

            if ($c === 'archived_at') {
                $insertCols[] = $c;
                $selectExpr[] = DB::raw("'" . $now . "' as archived_at");
                continue;
            }

            if ($c === 'created_at') {
                $insertCols[] = $c;
                $selectExpr[] = DB::raw("'" . $now . "' as created_at");
                continue;
            }

            if ($c === 'updated_at') {
                $insertCols[] = $c;
                $selectExpr[] = DB::raw("'" . $now . "' as updated_at");
                continue;
            }
        }

        if (!$insertCols || !$selectExpr) return;

        DB::table($historyTable)->where('cycle_id', $cycleId)->delete();

        $q = DB::table($exportTable)
            ->where('cycle_id', $cycleId)
            ->select($selectExpr);

        DB::table($historyTable)->insertUsing($insertCols, $q);

        DB::table($exportTable)->where('cycle_id', $cycleId)->delete();
    }

    public function syncBaseForEmployeeInCycle($employee, int $cycleId): void
    {
        $this->buildForEmployeeInCycle($employee, $cycleId);
    }

    public function syncBaseForEmployee($employee, ?int $cycleId = null): void
    {
        $this->buildForEmployee($employee, $cycleId);
    }

    public function buildForEmployee($employee, ?int $cycleId = null): void
    {
        $exportTable = $this->exportTableName();
        if (!$exportTable) return;

        $hasCycleCol = Schema::hasColumn($exportTable, 'cycle_id');

        if ($hasCycleCol) {
            $cid = (int)($cycleId ?: ($this->activeCycleId() ?: 0));
            if ($cid <= 0) return;
            $this->buildForEmployeeInCycle($employee, $cid);
            return;
        }

        $this->buildForEmployeeInCycle($employee, 0);
    }

    public function syncAndComputeAllEmployeesInCycle(int $cycleId, bool $resetBefore = false): void
    {
        $this->syncAllEmployeesInCycle($cycleId, $resetBefore);
        $this->computeAllInCycle($cycleId);
    }

    public function syncAllEmployeesInCycle(int $cycleId, bool $resetBefore = false): void
    {
        DB::disableQueryLog();

        $exportTable = $this->exportTableName();
        if (!$exportTable || !Schema::hasTable('employees')) return;

        if ($resetBefore) $this->clearExportForCycle($cycleId);

        $exportCols = Schema::getColumnListing($exportTable);
        $exportSet  = array_fill_keys($exportCols, true);

        $empCols = Schema::getColumnListing('employees');
        $empSet  = array_fill_keys($empCols, true);

        $hasCycleCol  = isset($exportSet['cycle_id']);
        $hasCreatedAt = isset($exportSet['created_at']);
        $hasUpdatedAt = isset($exportSet['updated_at']);

        $baseFields = [
            'full_name_th','full_name_en','employee_type','position','department','dept_abbr_qms','dept_abbr_hr',
            'sup_id','sup_name','div_mgr_id','div_mgr_name','dept_mgr_id','dept_mgr_name','plant_mgr_id','plant_mgr_name',
            'position_level',
            'attendance_total','attendance_sick','attendance_personal','attendance_maternity','attendance_ordain',
            'attendance_late','attendance_absent','attendance_warning','attendance_suspension',
            'score_teamwork','score_communication','score_leadership','score_attitude','score_planning','score_ownership',
            'score_problem_solving','score_dept_okr','score_company_okr','score_okr_reporting','score_system_smbr','score_bonus',
            'division_score_leadership','division_score_attitude',
            'q_percent',
            'citizen_id',
        ];

        $selectEmp = [];

        if (isset($empSet['id'])) $selectEmp[] = 'id';
        $selectEmp[] = 'employee_code';

        foreach ($baseFields as $f) {
            if (isset($empSet[$f]) && isset($exportSet[$f])) $selectEmp[] = $f;
        }
        $selectEmp = array_values(array_unique($selectEmp));

        $now = now();

        \App\Models\Employee::query()
            ->select($selectEmp)
            ->whereNotNull('employee_code')
            ->chunkById(1000, function ($chunk) use ($cycleId, $exportTable, $exportSet, $baseFields, $hasCycleCol, $hasCreatedAt, $hasUpdatedAt, $now) {
                $rows = [];

                foreach ($chunk as $emp) {
                    $code = $this->digitsOnly((string)($emp->employee_code ?? ''));
                    if (!$code) continue;

                    $row = ['employee_code' => $this->fit($exportTable, 'employee_code', $code)];
                    if ($hasCycleCol) $row['cycle_id'] = $cycleId;

                    foreach ($baseFields as $f) {
                        if (!isset($exportSet[$f])) continue;

                        $v = $emp->{$f} ?? null;

                        if (in_array($f, ['sup_id','div_mgr_id','dept_mgr_id','plant_mgr_id'], true)) {
                            $v = $this->digitsOnly((string)$v);
                        }

                        if (is_string($v)) {
                            $v = $this->fit($exportTable, $f, $v);
                        }

                        $row[$f] = $v;
                    }

                    if ($hasCreatedAt) $row['created_at'] = $now;
                    if ($hasUpdatedAt) $row['updated_at'] = $now;

                    $rows[] = $row;
                }

                if (!$rows) return;

                $uniqueKeys = $hasCycleCol ? ['cycle_id','employee_code'] : ['employee_code'];
                $updateCols = array_keys($rows[0]);
                $updateCols = array_values(array_filter($updateCols, function ($c) use ($uniqueKeys) {
                    if (in_array($c, $uniqueKeys, true)) return false;
                    if ($c === 'created_at') return false;
                    return true;
                }));

                DB::table($exportTable)->upsert($rows, $uniqueKeys, $updateCols);
            });
    }

    public function buildForEmployeeInCycle($employee, int $cycleId): void
    {
        DB::disableQueryLog();

        $exportTable = $this->exportTableName();
        if (!$exportTable) return;

        $exportCols = Schema::getColumnListing($exportTable);
        $exportSet  = array_fill_keys($exportCols, true);

        $hasCycleCol  = isset($exportSet['cycle_id']);
        $hasCreatedAt = isset($exportSet['created_at']);
        $hasUpdatedAt = isset($exportSet['updated_at']);

        $code = $this->digitsOnly((string)($employee->employee_code ?? ''));
        if (!$code) return;

        if ($hasCycleCol && $cycleId <= 0) return;

        $now = now();

        $row = ['employee_code' => $this->fit($exportTable, 'employee_code', $code)];
        if ($hasCycleCol) $row['cycle_id'] = $cycleId;

        $baseFields = [
            'full_name_th','full_name_en','employee_type','position','department','dept_abbr_qms','dept_abbr_hr',
            'sup_id','sup_name','div_mgr_id','div_mgr_name','dept_mgr_id','dept_mgr_name','plant_mgr_id','plant_mgr_name',
            'position_level',
            'attendance_total','attendance_sick','attendance_personal','attendance_maternity','attendance_ordain',
            'attendance_late','attendance_absent','attendance_warning','attendance_suspension',
            'score_teamwork','score_communication','score_leadership','score_attitude','score_planning','score_ownership',
            'score_problem_solving','score_dept_okr','score_company_okr','score_okr_reporting','score_system_smbr','score_bonus',
            'division_score_leadership','division_score_attitude',
            'q_percent',
            'citizen_id',
        ];

        foreach ($baseFields as $f) {
            if (!isset($exportSet[$f])) continue;

            $v = $employee->{$f} ?? null;

            if (in_array($f, ['sup_id','div_mgr_id','dept_mgr_id','plant_mgr_id'], true)) {
                $v = $this->digitsOnly((string)$v);
            }

            if (is_string($v)) $v = $this->fit($exportTable, $f, $v);

            $row[$f] = $v;
        }

        if ($hasCreatedAt) $row['created_at'] = $now;
        if ($hasUpdatedAt) $row['updated_at'] = $now;

        $uniqueKeys = $hasCycleCol ? ['cycle_id','employee_code'] : ['employee_code'];

        $updateCols = array_keys($row);
        $updateCols = array_values(array_filter($updateCols, function ($c) use ($uniqueKeys) {
            if (in_array($c, $uniqueKeys, true)) return false;
            if ($c === 'created_at') return false;
            return true;
        }));

        DB::table($exportTable)->upsert([$row], $uniqueKeys, $updateCols);
    }

    public function computeAllInCycle(int $cycleId): void
    {
        DB::disableQueryLog();

        $exportTable = $this->exportTableName();
        if (!$exportTable) return;

        if (!Schema::hasColumn($exportTable, 'cycle_id')) return;

        $cols = Schema::getColumnListing($exportTable);
        $set  = array_fill_keys($cols, true);

        $hasId = isset($set['id']);
        $hasEmpCode = isset($set['employee_code']);
        if (!$hasEmpCode) return;

        if ($hasId) {
            DB::table($exportTable)
                ->where('cycle_id', $cycleId)
                ->chunkById(800, function ($chunk) use ($exportTable, $set) {
                    foreach ($chunk as $row) {
                        $upd = $this->computeRowUpdate((array)$row, $set);
                        if ($upd) DB::table($exportTable)->where('id', $row->id)->update($upd);
                    }
                });
            return;
        }

        DB::table($exportTable)
            ->where('cycle_id', $cycleId)
            ->orderBy('employee_code')
            ->chunk(800, function ($chunk) use ($exportTable, $set, $cycleId) {
                foreach ($chunk as $row) {
                    $upd = $this->computeRowUpdate((array)$row, $set);
                    if ($upd) {
                        DB::table($exportTable)
                            ->where('cycle_id', $cycleId)
                            ->where('employee_code', $row->employee_code)
                            ->update($upd);
                    }
                }
            });
    }

    public function computeForCodesInCycle(array $codes, int $cycleId): void
    {
        DB::disableQueryLog();

        $exportTable = $this->exportTableName();
        if (!$exportTable) return;

        if (!Schema::hasColumn($exportTable, 'cycle_id')) return;

        $codes = array_values(array_unique(array_filter(array_map(function ($c) {
            $c = $this->digitsOnly((string)$c);
            return $c ?: null;
        }, $codes))));

        if (!$codes) return;

        $cols = Schema::getColumnListing($exportTable);
        $set  = array_fill_keys($cols, true);

        $rows = DB::table($exportTable)
            ->where('cycle_id', $cycleId)
            ->whereIn('employee_code', $codes)
            ->get();

        foreach ($rows as $row) {
            $upd = $this->computeRowUpdate((array)$row, $set);
            if ($upd) {
                if (isset($set['id']) && isset($row->id)) {
                    DB::table($exportTable)->where('id', $row->id)->update($upd);
                } else {
                    DB::table($exportTable)
                        ->where('cycle_id', $cycleId)
                        ->where('employee_code', $row->employee_code)
                        ->update($upd);
                }
            }
        }
    }

    private function exportTableName(): ?string
    {
        if (Schema::hasTable('export_employee')) return 'export_employee';
        if (Schema::hasTable('export_employees')) return 'export_employees';
        return null;
    }

    private function activeCycleId(): ?int
    {
        if (!Schema::hasTable('cycles')) return null;

        try {
            if (Schema::hasColumn('cycles', 'is_active')) {
                $row = DB::table('cycles')->where('is_active', true)->orderByDesc('id')->first();
                if ($row && isset($row->id)) return (int)$row->id;
            }

            $row = DB::table('cycles')->orderByDesc('id')->first();
            if ($row && isset($row->id)) return (int)$row->id;
        } catch (\Throwable $e) {
            return null;
        }

        return null;
    }

    private function digitsOnly(string $v): string
    {
        $s = preg_replace('/\D+/', '', (string)$v) ?? '';
        return $s ?: '';
    }

    private function colMaxLen(string $table, string $col): ?int
    {
        $key = $table . '.' . $col;
        if (array_key_exists($key, $this->colLenCache)) return $this->colLenCache[$key];

        try {
            $row = DB::selectOne(
                "SELECT CHARACTER_MAXIMUM_LENGTH AS len
                 FROM information_schema.COLUMNS
                 WHERE TABLE_SCHEMA = DATABASE()
                   AND TABLE_NAME = ?
                   AND COLUMN_NAME = ?
                 LIMIT 1",
                [$table, $col]
            );
            $len = $row && isset($row->len) ? (int)$row->len : null;
        } catch (\Throwable $e) {
            $len = null;
        }

        $this->colLenCache[$key] = $len;
        return $len;
    }

    private function fit(string $table, string $col, string $val): string
    {
        $val = trim($val);
        $len = $this->colMaxLen($table, $col);
        if (!$len || $len <= 0) return $val;

        if (mb_strlen($val, 'UTF-8') <= $len) return $val;
        return mb_substr($val, 0, $len, 'UTF-8');
    }

    private function setIfExists(array &$upd, array $set, string $col, $val): void
    {
        if (isset($set[$col])) $upd[$col] = $val;
    }

    private function gradeTextFromLetter(string $grade, float $warning = 0.0, float $suspension = 0.0): string
    {
        $g = strtoupper(trim((string)$grade));
        if ($g === 'A') $text = 'Outstanding';
        elseif ($g === 'B') $text = 'Exceeds expectation';
        elseif ($g === 'C') $text = 'Meets expectation';
        elseif ($g === 'D') $text = 'Below expectation';
        else $text = 'Needs imporvement';

        if ($suspension > 0) {
            $text .= '(suspension)';
        } elseif ($warning > 0) {
            $text .= '(warning)';
        }

        return $text;
    }

    private function pickScore(array $row, array $set, array $candidates): ?float
    {
        foreach ($candidates as $c) {
            if (!isset($set[$c])) continue;
            $v = $row[$c] ?? null;
            if ($v === null || $v === '') continue;
            if (!is_numeric($v)) continue;
            return (float)$v;
        }
        return null;
    }

    private function computeRoleIp(array $row, array $set, int $lvl, string $role): array
    {
        $wIP = [1=>50,2=>50,3=>40,4=>20,5=>10][$lvl] ?? 0;

        $baseTopics = [
            'score_teamwork',
            'score_communication',
            'score_planning',
            'score_ownership',
            'score_problem_solving',
        ];

        $ipSum = 0.0;
        $ipFull = 0.0;

        foreach ($baseTopics as $c) {
            if (!isset($set[$c])) continue;
            $v = $row[$c] ?? null;
            if ($v === null || $v === '') continue;
            if (!is_numeric($v)) continue;
            $ipSum += (float)$v;
            $ipFull += 10.0;
        }

        $lead = null;
        $atti = null;

        if ($role === 'division') {
            $lead = $this->pickScore($row, $set, ['division_score_leadership', 'div_score_leadership', 'supervisor_score_leadership', 'sup_score_leadership', 'score_leadership']);
            $atti = $this->pickScore($row, $set, ['division_score_attitude', 'div_score_attitude', 'supervisor_score_attitude', 'sup_score_attitude', 'score_attitude']);
        } else {
            $lead = $this->pickScore($row, $set, ['supervisor_score_leadership', 'sup_score_leadership', 'score_leadership']);
            $atti = $this->pickScore($row, $set, ['supervisor_score_attitude', 'sup_score_attitude', 'score_attitude']);
        }

        if ($lead !== null) { $ipSum += $lead; $ipFull += 10.0; }
        if ($atti !== null) { $ipSum += $atti; $ipFull += 10.0; }

        $ipPercent = 0.0;
        $ipWeighted = 0.0;

        if ($ipFull > 0) {
            $ipPercent  = ($ipSum / $ipFull) * 100.0;
            $ipWeighted = ($ipSum / $ipFull) * $wIP;
        }

        return [
            'ip_sum' => $ipSum,
            'ip_full' => $ipFull,
            'ip_percent' => $ipPercent,
            'ip_weighted' => $ipWeighted,
        ];
    }

    private function computeRowUpdate(array $row, array $set): array
    {
        $lvl = (int)($row['position_level'] ?? 0);
        if ($lvl < 1) $lvl = 2;
        if ($lvl > 5) $lvl = 5;

        $wAttendance = [1=>50,2=>20,3=>10,4=>10,5=>0][$lvl] ?? 0;

        $wDeptOkr=0; $wCompanyOkr=0; $wOkrRep=0; $wSystem=0; $wBonus=0;
        if ($lvl === 1) { $wBonus=5; }
        if ($lvl === 2) { $wDeptOkr=20; $wSystem=10; $wBonus=5; }
        if ($lvl === 3) { $wDeptOkr=30; $wSystem=20; $wBonus=5; }
        if ($lvl === 4) { $wDeptOkr=30; $wCompanyOkr=10; $wOkrRep=10; $wSystem=20; $wBonus=5; }
        if ($lvl === 5) { $wDeptOkr=30; $wCompanyOkr=30; $wOkrRep=10; $wSystem=20; $wBonus=0; }

        $base = (float)($row['attendance_total'] ?? 100);
        if ($base <= 0) $base = 100;

        $absent   = (float)($row['attendance_absent'] ?? 0);
        $sick     = (float)($row['attendance_sick'] ?? 0);
        $personal = (float)($row['attendance_personal'] ?? 0);
        $late     = (float)($row['attendance_late'] ?? 0);

        $deduct = ($absent * 3.0) + ($sick * 1.0) + ($personal * 1.0) + ($late * 0.25);
        $raw = max(0.0, $base - $deduct);
        $attendancePoints = ($raw / $base) * $wAttendance;

        $deptOkr    = (float)($row['score_dept_okr'] ?? 0);
        $companyOkr = (float)($row['score_company_okr'] ?? 0);
        $okrRep     = (float)($row['score_okr_reporting'] ?? 0);
        $system     = (float)($row['score_system_smbr'] ?? 0);
        $bonusRaw   = (float)($row['score_bonus'] ?? 0);

        $deptOkrPts    = ($deptOkr / 10.0) * $wDeptOkr;
        $companyOkrPts = ($companyOkr / 10.0) * $wCompanyOkr;
        $okrRepPts     = ($okrRep / 10.0) * $wOkrRep;
        $systemPts     = ($system / 5.0) * $wSystem;

       $bonusPts = 0.0;
        if ($wBonus > 0) {
    $bonusPts = max(-(float)$wBonus, min((float)$wBonus, (float)$bonusRaw));
}


        $supIp = $this->computeRoleIp($row, $set, $lvl, 'supervisor');
        $divIp = $this->computeRoleIp($row, $set, $lvl, 'division');

        $warning = (float)($row['attendance_warning'] ?? 0);
        $susp    = (float)($row['attendance_suspension'] ?? 0);

        $supTotal = $attendancePoints + (float)$supIp['ip_weighted'] + $deptOkrPts + $companyOkrPts + $okrRepPts + $systemPts + $bonusPts;
        $supTotal = round($supTotal, 2);
        [$supGrade, $supGradeText] = $this->gradeFromTotal($supTotal);

        if ($susp > 0) {
            if (in_array($supGrade, ['A','B','C'], true)) $supGrade = 'D';
        } elseif ($warning > 0) {
            if (in_array($supGrade, ['A','B'], true)) $supGrade = 'C';
        }
        $supGradeText = $this->gradeTextFromLetter($supGrade, $warning, $susp);

        $divTotal = $attendancePoints + (float)$divIp['ip_weighted'] + $deptOkrPts + $companyOkrPts + $okrRepPts + $systemPts + $bonusPts;
        $divTotal = round($divTotal, 2);
        [$divGrade, $divGradeText] = $this->gradeFromTotal($divTotal);

        if ($susp > 0) {
            if (in_array($divGrade, ['A','B','C'], true)) $divGrade = 'D';
        } elseif ($warning > 0) {
            if (in_array($divGrade, ['A','B'], true)) $divGrade = 'C';
        }
        $divGradeText = $this->gradeTextFromLetter($divGrade, $warning, $susp);

        $upd = [];

        $this->setIfExists($upd, $set, 'attendance_points', round($attendancePoints, 2));

        $this->setIfExists($upd, $set, 'ip_sum', round((float)$supIp['ip_sum'], 2));
        $this->setIfExists($upd, $set, 'ip_percent', round((float)$supIp['ip_percent'], 2));
        $this->setIfExists($upd, $set, 'ip_weighted', round((float)$supIp['ip_weighted'], 2));

        $this->setIfExists($upd, $set, 'final_score', $supTotal);
        $this->setIfExists($upd, $set, 'grade_letter', $supGrade);
        $this->setIfExists($upd, $set, 'grade_text', $supGradeText);

        $this->setIfExists($upd, $set, 'supervisor_final_score', $supTotal);
        $this->setIfExists($upd, $set, 'supervisor_grade', $supGrade);
        $this->setIfExists($upd, $set, 'supervisor_grade_letter', $supGrade);
        $this->setIfExists($upd, $set, 'supervisor_grade_text', $supGradeText);
        $this->setIfExists($upd, $set, 'supervisor_ip_sum', round((float)$supIp['ip_sum'], 2));
        $this->setIfExists($upd, $set, 'supervisor_ip_percent', round((float)$supIp['ip_percent'], 2));
        $this->setIfExists($upd, $set, 'supervisor_ip_weighted', round((float)$supIp['ip_weighted'], 2));

        $this->setIfExists($upd, $set, 'division_final_score', $divTotal);
        $this->setIfExists($upd, $set, 'division_grade', $divGrade);
        $this->setIfExists($upd, $set, 'division_grade_letter', $divGrade);
        $this->setIfExists($upd, $set, 'division_grade_text', $divGradeText);
        $this->setIfExists($upd, $set, 'division_ip_sum', round((float)$divIp['ip_sum'], 2));
        $this->setIfExists($upd, $set, 'division_ip_percent', round((float)$divIp['ip_percent'], 2));
        $this->setIfExists($upd, $set, 'division_ip_weighted', round((float)$divIp['ip_weighted'], 2));

        if (isset($set['updated_at'])) $upd['updated_at'] = now();

        return $upd;
    }

    private function gradeFromTotal(float $total): array
    {
        if ($total >= 95) return ['A', 'Outstanding'];
        if ($total >= 85) return ['B', 'Exceeds expectation'];
        if ($total >= 75) return ['C', 'Meets expectation'];
        if ($total >= 60) return ['D', 'Below expectation'];
        return ['F', 'Needs imporvement'];
    }
}
