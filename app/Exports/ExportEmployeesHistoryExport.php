<?php

namespace App\Exports;

use App\Models\Cycle;
use App\Models\Employee;
use App\Models\ExportEmployeeHistory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class ExportEmployeesHistoryExport implements FromCollection, WithHeadings, WithEvents
{
    protected ?int $cycleId;

    public function __construct(?int $cycleId = null)
    {
        $this->cycleId = $cycleId;
    }

    protected array $columns = [
        'employee_code',
        'full_name_th',
        'full_name_en',
        'employee_type',
        'position',
        'department',
        'dept_abbr_qms',
        'dept_abbr_hr',

        'sup_id',
        'sup_name',
        'div_mgr_id',
        'div_mgr_name',
        'dept_mgr_id',
        'dept_mgr_name',
        'plant_mgr_id',
        'plant_mgr_name',

        'citizen_id',

        'attendance_total',
        'attendance_sick',
        'attendance_personal',
        'attendance_maternity',
        'attendance_ordain',
        'attendance_late',
        'attendance_absent',
        'attendance_warning',
        'attendance_suspension',

        'score_teamwork',
        'score_communication',
        'score_leadership_dup',
        'score_attitude_dup',
        'score_planning',
        'score_ownership',
        'score_problem_solving',

        'score_dept_okr',
        'score_company_okr',
        'score_okr_reporting',
        'score_system_smbr',
        'score_bonus',

        'division_score_leadership',
        'division_score_attitude',
        'division_final_score',
        'division_grade',
        'division_grade_text',

        'score_leadership',
        'score_attitude',
        'supervisor_final_score',
        'supervisor_grade',
        'supervisor_grade_text',

        'q_percent',
    ];

    protected array $aliasMap = [
        'score_attitude' => ['score_attritude', 'attritude'],
        'division_score_attitude' => ['division_score_attritude'],
        'score_leadership_dup' => ['score_leadership'],
        'score_attitude_dup' => ['score_attitude', 'score_attritude', 'attritude'],
        'citizen_id' => ['emp_citizen_id', 'citizen_id', 'id_thai_hash'],
    ];

    protected array $dashIfNullOrZeroColumns = [
        'score_leadership_dup',
        'score_attitude_dup',
        'score_leadership',
        'score_attitude',
        'supervisor_final_score',
        'division_score_leadership',
        'division_score_attitude',
        'division_final_score',
        'q_percent',
    ];

    protected array $dashIfNullColumns = [
        'supervisor_grade',
        'supervisor_grade_text',
        'division_grade',
        'division_grade_text',
    ];

    protected array $dashIfAttendanceZeroOrNullColumns = [
        'attendance_sick',
        'attendance_personal',
        'attendance_maternity',
        'attendance_ordain',
        'attendance_late',
        'attendance_absent',
        'attendance_warning',
        'attendance_suspension',
    ];

    protected array $levelMap = [
        1 => ['cooking','driver','maid','operator','senior operator','support mat','tp man'],
        2 => ['foreman','leader','senior staff','senior technician','staff','technician'],
        3 => ['engineer','senior engineer','supervisor'],
        4 => ['assist manager','assistant manager','manager'],
        5 => ['deputy general manager','general manager'],
    ];

    protected function normPos(?string $pos): string
    {
        $s = trim((string)$pos);
        if ($s === '') return '';
        $s = function_exists('mb_strtolower') ? mb_strtolower($s, 'UTF-8') : strtolower($s);
        $s = preg_replace('/[^\p{L}\p{N}]+/u', ' ', $s);
        $s = trim(preg_replace('/\s+/u', ' ', $s));
        return $s;
    }

    protected ?array $levelLookup = null;

    protected function buildLookup(): array
    {
        if ($this->levelLookup !== null) return $this->levelLookup;

        $lookup = [];
        foreach ($this->levelMap as $level => $names) {
            foreach ($names as $name) {
                $lookup[$this->normPos($name)] = (int)$level;
            }
        }
        return $this->levelLookup = $lookup;
    }

    protected function inferLevelFromEmp($emp): ?int
    {
        $lookup = $this->buildLookup();

        $pos = $this->normPos(property_exists($emp, 'position') ? $emp->position : null);
        if ($pos !== '' && isset($lookup[$pos])) return $lookup[$pos];

        $pos2 = $this->normPos(property_exists($emp, 'position_name') ? $emp->position_name : null);
        if ($pos2 !== '' && isset($lookup[$pos2])) return $lookup[$pos2];

        $lv = (int)(property_exists($emp, 'position_level') ? ($emp->position_level ?? 0) : 0);
        if ($lv >= 1 && $lv <= 5) return $lv;

        return null;
    }

    protected function getFinalScoreFromEmp($emp, ?string $scoreCol): float
    {
        $v = null;

        if ($scoreCol && property_exists($emp, $scoreCol)) {
            $v = $emp->{$scoreCol} ?? null;
        } else {
            $v = property_exists($emp, 'final_score') ? ($emp->final_score ?? null) : null;
            if ($v === null) $v = property_exists($emp, 'supervisor_final_score') ? ($emp->supervisor_final_score ?? null) : null;
        }

        if ($v === null || $v === '') return 0.0;
        if (!is_numeric($v)) return 0.0;

        return (float)$v;
    }

    protected function bestActiveTable(): ?string
    {
        $candidates = [];
        if (Schema::hasTable('export_employee')) $candidates[] = 'export_employee';
        if (Schema::hasTable('export_employees')) $candidates[] = 'export_employees';
        if (empty($candidates)) return null;
        if (count($candidates) === 1) return $candidates[0];

        $want = $this->columns;
        foreach ($this->aliasMap as $k => $alts) {
            foreach ($alts as $a) $want[] = $a;
        }
        $want = array_values(array_unique($want));

        $best = null;
        $bestScore = -1;

        foreach ($candidates as $t) {
            $score = 0;
            foreach ($want as $c) {
                if (Schema::hasColumn($t, $c)) $score++;
            }
            if ($score > $bestScore) {
                $bestScore = $score;
                $best = $t;
            }
        }

        return $best ?? $candidates[0];
    }

    public function collection()
    {
        $columns                        = $this->columns;
        $dashIfNullOrZeroColumns        = $this->dashIfNullOrZeroColumns;
        $dashIfNullColumns              = $this->dashIfNullColumns;
        $dashIfAttendanceZeroOrNullCols = $this->dashIfAttendanceZeroOrNullColumns;
        $aliasMap                       = $this->aliasMap;

        $histModel = new ExportEmployeeHistory();
        $historyTable = method_exists($histModel, 'getTable') ? $histModel->getTable() : null;

        $activeTable = $this->bestActiveTable();
        $sourceTable = $activeTable ?: $historyTable;

        if ($this->cycleId && $historyTable && Schema::hasTable($historyTable) && Schema::hasColumn($historyTable, 'cycle_id')) {
            $hasHistoryForCycle = DB::table($historyTable)->where('cycle_id', $this->cycleId)->exists();
            if ($hasHistoryForCycle) $sourceTable = $historyTable;
        }

        if (!$sourceTable || !Schema::hasTable($sourceTable)) {
            return collect();
        }

        $calcCols = [];
        $scoreCol = null;

        if (Schema::hasColumn($sourceTable, 'final_score')) {
            $scoreCol = 'final_score';
            $calcCols[] = 'final_score';
        } elseif (Schema::hasColumn($sourceTable, 'supervisor_final_score')) {
            $scoreCol = 'supervisor_final_score';
        }

        if (Schema::hasColumn($sourceTable, 'position_name') && !in_array('position_name', $columns, true)) {
            $calcCols[] = 'position_name';
        }

        $aliasCols = [];
        foreach ($aliasMap as $key => $alts) {
            foreach ($alts as $a) {
                if (Schema::hasColumn($sourceTable, $a)) $aliasCols[] = $a;
            }
        }

        $selectCols = array_values(array_unique(array_merge($columns, $calcCols, $aliasCols)));
        $selectCols = array_values(array_filter($selectCols, fn($c) => Schema::hasColumn($sourceTable, $c)));

        if (empty($selectCols)) {
            return collect();
        }

        $src = 'src';
        $empAlias = 'emp';

        $q = DB::table($sourceTable . ' as ' . $src);

        $selectPrefixed = [];
        foreach ($selectCols as $c) {
            $selectPrefixed[] = $src . '.' . $c . ' as ' . $c;
        }
        $q->select($selectPrefixed);

        $empModel = new Employee();
        $empTable = method_exists($empModel, 'getTable') ? $empModel->getTable() : 'employees';

        $canJoinEmp =
            $empTable &&
            Schema::hasTable($empTable) &&
            Schema::hasColumn($empTable, 'employee_code') &&
            Schema::hasColumn($empTable, 'citizen_id') &&
            Schema::hasColumn($sourceTable, 'employee_code');

        if ($canJoinEmp) {
            $q->leftJoin($empTable . ' as ' . $empAlias, $empAlias . '.employee_code', '=', $src . '.employee_code');
            $q->addSelect(DB::raw($empAlias . '.citizen_id as emp_citizen_id'));
        }

        if ($this->cycleId && Schema::hasColumn($sourceTable, 'cycle_id')) {
            $q->where($src . '.cycle_id', $this->cycleId);
        } elseif (!$this->cycleId && Schema::hasColumn($sourceTable, 'cycle_id')) {
            $activeId = Cycle::activeId();
            if ($activeId) $q->where($src . '.cycle_id', $activeId);
        }

        $employees = $q->get();

        $getVal = function ($emp, string $col) use ($aliasMap) {
            if (property_exists($emp, $col)) return $emp->{$col} ?? null;
            if (isset($aliasMap[$col])) {
                foreach ($aliasMap[$col] as $a) {
                    if (property_exists($emp, $a)) return $emp->{$a} ?? null;
                }
            }
            return null;
        };

        $toInt = function ($v): int {
            if ($v === null) return 0;
            if (is_int($v)) return $v;
            if (is_float($v)) return (int)$v;
            if (is_numeric($v)) return (int)$v;
            $s = preg_replace('/[^\d]+/', '', (string)$v);
            return $s === '' ? 0 : (int)$s;
        };

        $gradeRank = function (string $g): int {
            $g = strtoupper(trim($g));
            return match ($g) {
                'A' => 5,
                'B' => 4,
                'C' => 3,
                'D' => 2,
                'F' => 1,
                default => 0,
            };
        };

        $defaultGradeText = function (string $g): string {
            $g = strtoupper(trim($g));
            return match ($g) {
                'A' => 'Outstanding',
                'B' => 'Exceeds expectation',
                'C' => 'Meets expectation',
                'D' => 'Need improvement',
                'F' => 'Unsatisfactory',
                default => 'N/A',
            };
        };

        $appendTag = function (string $text, string $tag): string {
            $t = trim($text);
            if ($t === '' || $t === '-' || strtoupper($t) === 'N/A') $t = 'N/A';
            $needle = '(' . $tag . ')';
            if ($t !== 'N/A' && stripos($t, $needle) === false) $t .= $needle;
            return $t;
        };

        $rows = $employees->map(function ($emp) use (
            $columns,
            $dashIfNullOrZeroColumns,
            $dashIfNullColumns,
            $dashIfAttendanceZeroOrNullCols,
            $getVal,
            $toInt,
            $gradeRank,
            $defaultGradeText,
            $appendTag
        ) {
            $row = [];

            $supName = trim((string) ($getVal($emp, 'sup_name') ?? ''));
            $divName = trim((string) ($getVal($emp, 'div_mgr_name') ?? ''));

            if (function_exists('mb_strtolower')) {
                $supNameNorm = mb_strtolower($supName, 'UTF-8');
                $divNameNorm = mb_strtolower($divName, 'UTF-8');
            } else {
                $supNameNorm = strtolower($supName);
                $divNameNorm = strtolower($divName);
            }

            $isSupAlsoDivision = ($supNameNorm !== '' && $supNameNorm === $divNameNorm);

            $supervisorFields = [
                'score_leadership',
                'score_attitude',
                'supervisor_final_score',
                'supervisor_grade',
                'supervisor_grade_text',
            ];

            $hasSupervisorData = false;
            foreach ($supervisorFields as $f) {
                $v = $getVal($emp, $f);
                if ($v === null) continue;
                if (is_string($v) && trim($v) === '') continue;
                if (is_numeric($v) && (float)$v == 0.0) continue;
                $hasSupervisorData = true;
                break;
            }

            $divisionFields = [
                'division_score_leadership',
                'division_score_attitude',
                'division_final_score',
                'division_grade',
                'division_grade_text',
            ];

            $hasDivisionData = false;
            foreach ($divisionFields as $f) {
                $v = $getVal($emp, $f);
                if ($v === null) continue;
                if (is_string($v) && trim($v) === '') continue;
                if (is_numeric($v) && (float)$v == 0.0) continue;
                $hasDivisionData = true;
                break;
            }

            $warnCnt = $toInt($getVal($emp, 'attendance_warning'));
            $suspCnt = $toInt($getVal($emp, 'attendance_suspension'));

            $capLetter = null;
            $tag = null;
            if ($suspCnt > 0) {
                $capLetter = 'D';
                $tag = 'suspension';
            } elseif ($warnCnt > 0) {
                $capLetter = 'C';
                $tag = 'warning';
            }

            $overrides = [];

            $applyCap = function (string $grade, string $cap) use ($gradeRank): string {
                $g = strtoupper(trim($grade));
                $r = $gradeRank($g);
                $capR = $gradeRank($cap);
                if ($r === 0) return $cap;
                return $r > $capR ? $cap : $g;
            };

            if ($capLetter !== null) {
                $roles = [
                    ['supervisor_grade', 'supervisor_grade_text'],
                    ['division_grade', 'division_grade_text'],
                ];

                foreach ($roles as $pair) {
                    [$gCol, $tCol] = $pair;

                    $rawG = strtoupper(trim((string)($getVal($emp, $gCol) ?? '')));
                    $rawT = trim((string)($getVal($emp, $tCol) ?? ''));

                    $newG = $applyCap($rawG, $capLetter);

                    $baseText = $rawT;
                    if ($baseText === '' || $baseText === '-' || strtoupper($baseText) === 'N/A') {
                        $baseText = $defaultGradeText($newG);
                    }

                    if ($tag !== null) {
                        $baseText = $appendTag($baseText, $tag);
                    }

                    $overrides[$gCol] = $newG;
                    $overrides[$tCol] = $baseText;
                }
            }

            foreach ($columns as $col) {
                $value = array_key_exists($col, $overrides) ? $overrides[$col] : $getVal($emp, $col);

                if (
                    $isSupAlsoDivision &&
                    $hasSupervisorData &&
                    !$hasDivisionData &&
                    in_array($col, [
                        'division_score_leadership',
                        'division_score_attitude',
                        'division_final_score',
                        'division_grade',
                        'division_grade_text',
                    ], true)
                ) {
                    $row[] = '-';
                    continue;
                }

                if ($col === 'citizen_id') {
                    if ($value === null || (is_string($value) && trim($value) === '')) {
                        $row[] = '-';
                        continue;
                    }
                    $s = trim((string)$value);
                    $digits = preg_replace('/\D+/', '', $s);
                    if ($digits === '') {
                        $row[] = '-';
                        continue;
                    }
                    $row[] = (strlen($digits) <= 15 && is_numeric($digits)) ? (int)$digits : $digits;
                    continue;
                }

                if (in_array($col, $dashIfNullOrZeroColumns, true)) {
                    if (
                        $value === null ||
                        $value === 0 ||
                        $value === 0.0 ||
                        (is_string($value) && trim($value) === '0')
                    ) {
                        $value = '-';
                    }
                    $row[] = $value;
                    continue;
                }

                if (in_array($col, $dashIfNullColumns, true)) {
                    if ($value === null || (is_string($value) && trim($value) === '')) {
                        $value = '-';
                    }
                    $row[] = $value;
                    continue;
                }

                if (in_array($col, $dashIfAttendanceZeroOrNullCols, true)) {
                    if (
                        $value === null ||
                        $value === 0 ||
                        $value === 0.0 ||
                        (is_string($value) && trim($value) === '0') ||
                        (is_string($value) && trim($value) === '')
                    ) {
                        $value = '-';
                    }
                    $row[] = $value;
                    continue;
                }

                if ($value === null || (is_string($value) && trim($value) === '')) {
                    $value = 'N/A';
                }

                $row[] = $value;
            }

            return $row;
        });

        if ($employees->isNotEmpty()) {
            $rows->push(array_fill(0, count($this->columns), null));

            $levelNames = [
                1 => 'Operator',
                2 => 'Staff',
                3 => 'Supervisor',
                4 => 'Manager',
                5 => 'GM',
            ];

            $sum = [1 => 0.0, 2 => 0.0, 3 => 0.0, 4 => 0.0, 5 => 0.0];
            $cnt = [1 => 0,   2 => 0,   3 => 0,   4 => 0,   5 => 0];

            $scoreCol2 = null;
            if ($sourceTable && Schema::hasColumn($sourceTable, 'final_score')) {
                $scoreCol2 = 'final_score';
            } elseif ($sourceTable && Schema::hasColumn($sourceTable, 'supervisor_final_score')) {
                $scoreCol2 = 'supervisor_final_score';
            }

            foreach ($employees as $emp) {
                $lv = $this->inferLevelFromEmp($emp);
                if (!$lv || $lv < 1 || $lv > 5) continue;

                $cnt[$lv] = ($cnt[$lv] ?? 0) + 1;
                $sum[$lv] = ($sum[$lv] ?? 0.0) + $this->getFinalScoreFromEmp($emp, $scoreCol2);
            }

            for ($lv = 1; $lv <= 5; $lv++) {
                $label = 'เฉลี่ยลำดับชั้น ' . $lv . (isset($levelNames[$lv]) ? " ({$levelNames[$lv]})" : '');
                $c = (int)($cnt[$lv] ?? 0);
                $avg = $c > 0 ? round(($sum[$lv] ?? 0.0) / $c, 2) : 0;

                $summaryRow = array_fill(0, count($this->columns), null);
                $summaryRow[0] = $label;
                $summaryRow[1] = $c;
                $summaryRow[2] = $avg;

                $rows->push($summaryRow);
            }
        }

        return $rows;
    }

    public function headings(): array
    {
        return [
            'รหัสพนักงาน',
            'ชื่อ-สกุล(ไทย)',
            'ชื่อ-สกุล(Eng)',
            'ประเภท',
            'ตำแหน่ง',
            'แผนก/ฝ่าย',
            "ตัวย่อแผนก\n(ใช้ใน QMS)",
            "ตัวย่อส่วนงาน\n(ใช้ใน HR)",

            'ID Supervisor',
            'Supervisor Name',
            'ID Division MGR',
            'Division Manager Name',
            'ID Dept MGR',
            'Dept Manager Name',
            'ID Plant MGR',
            'Plant Manager Name',

            'เลขที่ประกันสังคม',

            'รวม',
            'ป่วย',
            'ลากิจ',
            'ลาคลอด',
            'บวช',
            'มาสาย',
            'ขาดงาน',
            'หนังสือเตือน',
            'พักงาน',

            'Teamwork',
            'Communication',
            'Leadership',
            'Attritude',
            'Planning/Proactivity',
            'Ownership/Responsibility',
            'Problem solving',

            'Department level OKR score',
            'Company level OKR score',
            'OKR - Reporting score',
            'System(SMBR)',
            'Bonus score',

            'Leadership(Division)',
            'Attitude(Division)',
            'คะแนนรวม Division',
            'เกรด Division',
            'เกรด Division (คำบรรยาย)',

            'Leadership(Supervisor)',
            'Attitude(Supervisor)',
            'คะแนนรวม Supervisor',
            'เกรด Supervisor',
            'เกรด Supervisor (คำบรรยาย)',

            'คะแนนประเมินตนเอง (%)',
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                $sheet->insertNewRowBefore(1, 1);

                $colIdx = [];
                foreach ($this->columns as $i => $c) {
                    $colIdx[$c] = $i + 1;
                }

                $colL = function (int $idx): string {
                    return Coordinate::stringFromColumnIndex($idx);
                };

                $mergeGroup = function (string $startKey, string $endKey, string $label, string $fillArgb) use ($sheet, $colIdx, $colL) {
                    if (!isset($colIdx[$startKey]) || !isset($colIdx[$endKey])) return;
                    $s = (int)$colIdx[$startKey];
                    $e = (int)$colIdx[$endKey];
                    if ($s <= 0 || $e <= 0 || $e < $s) return;

                    $range = $colL($s) . "1:" . $colL($e) . "1";
                    $sheet->mergeCells($range);
                    $sheet->setCellValue($colL($s) . "1", $label);
                    $sheet->getStyle($range)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB($fillArgb);
                };

                $setCell = function (string $key, string $label, string $fillArgb) use ($sheet, $colIdx, $colL) {
                    if (!isset($colIdx[$key])) return;
                    $c = (int)$colIdx[$key];
                    if ($c <= 0) return;

                    $cell = $colL($c) . "1";
                    $sheet->setCellValue($cell, $label);
                    $sheet->getStyle($cell)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB($fillArgb);
                };

                $mergeGroup('sup_id', 'sup_name', 'ลำดับชั้น 1', 'FFFFF2CC');
                $mergeGroup('div_mgr_id', 'div_mgr_name', 'ลำดับชั้น 2', 'FFFFF2CC');
                $mergeGroup('dept_mgr_id', 'dept_mgr_name', 'ลำดับชั้น 3', 'FFFFF2CC');
                $mergeGroup('plant_mgr_id', 'plant_mgr_name', 'ลำดับชั้น 4', 'FFFFF2CC');

                $mergeGroup('attendance_total', 'attendance_suspension', 'Attendance', 'FFCCE5FF');
                $mergeGroup('score_teamwork', 'score_problem_solving', 'Individual Performance score', 'FFC6EFCE');

                $setCell('score_dept_okr', 'Department level OKR score', 'FFFFF2CC');
                $setCell('score_company_okr', 'Company level OKR score', 'FFFFE5CC');
                $setCell('score_okr_reporting', 'OKR - Reporting score', 'FFFFC7CE');
                $setCell('score_system_smbr', 'System(SMBR)', 'FF9C0006');
                $setCell('score_bonus', 'Bonus score', 'FFD9D2E9');

                $highestRow    = $sheet->getHighestRow();
                $highestColumn = $sheet->getHighestColumn();

                $allRange = "A1:{$highestColumn}{$highestRow}";
                $sheet->getStyle($allRange)->getFont()->setName('CordiaUPC')->setSize(12);

                $headerRange = "A1:{$highestColumn}2";
                $sheet->getStyle($headerRange)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER)->setVertical(Alignment::VERTICAL_CENTER)->setWrapText(true);
                $sheet->getStyle($headerRange)->getFont()->setBold(true);

                if (isset($colIdx['citizen_id'])) {
                    $col = $colL((int)$colIdx['citizen_id']);
                    $startRow = 3;
                    $endRow = $highestRow > 3 ? $highestRow : 3;
                    $sheet->getStyle("{$col}{$startRow}:{$col}{$endRow}")
                        ->getNumberFormat()
                        ->setFormatCode(NumberFormat::FORMAT_NUMBER);
                }

                $averageRows = [];
                for ($row = 2; $row <= $highestRow; $row++) {
                    $cellValue = (string) $sheet->getCell("A{$row}")->getValue();
                    if (strpos($cellValue, 'เฉลี่ยลำดับชั้น') === 0) {
                        $averageRows[] = $row;
                    }
                }

                if (!empty($averageRows)) {
                    $first = min($averageRows);
                    $last  = max($averageRows);

                    $sheet->getStyle("A{$first}:C{$last}")
                        ->getFill()
                        ->setFillType(Fill::FILL_SOLID)
                        ->getStartColor()
                        ->setARGB('FFEAE4F6');
                }
            },
        ];
    }
}
