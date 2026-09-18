<?php

namespace App\Services;

use Illuminate\Support\Facades\Schema;
use App\Models\ExportEmployee;

class AssessmentScoreCalculator
{
    protected static array $colsCache = [];

    protected function cols(string $table): array
    {
        if (!isset(self::$colsCache[$table])) {
            self::$colsCache[$table] = Schema::hasTable($table) ? Schema::getColumnListing($table) : [];
        }
        return self::$colsCache[$table];
    }

    protected function hasCol(string $table, string $col): bool
    {
        return in_array($col, $this->cols($table), true);
    }

    protected function numOrNull($v): ?float
    {
        if ($v === null) return null;
        if (is_float($v) || is_int($v)) return (float)$v;

        $s = trim((string)$v);
        if ($s === '') return null;

        $k = strtolower($s);
        $k = preg_replace('/\s+/', '', $k) ?? $k;
        if (in_array($k, ['na','n/a','n\\a','-','--','–','—'], true)) return null;

        $s = str_replace([',', ' '], '', $s);
        if (!is_numeric($s)) return null;
        return (float)$s;
    }

    protected function pickFirstRaw(ExportEmployee $row, array $cols, $default = null)
    {
        $t = $row->getTable();
        foreach ($cols as $c) {
            if ($this->hasCol($t, $c)) return $row->{$c};
        }
        return $default;
    }

    protected function pickFirstValue(ExportEmployee $row, array $cols): ?float
    {
        $t = $row->getTable();
        foreach ($cols as $c) {
            if (!$this->hasCol($t, $c)) continue;
            $v = $this->numOrNull($row->{$c});
            if ($v !== null) return $v;
        }
        return null;
    }

    protected function detectLevel(ExportEmployee $row): int
    {
        $lvl = $this->numOrNull($this->pickFirstRaw($row, ['position_level'], null));
        if ($lvl !== null) return max(1, min(8, (int)$lvl));

        $pos = strtolower(trim((string)$this->pickFirstRaw($row, ['position'], '')));
        if ($pos === '') return 2;

        $p = preg_replace('/\s+/', ' ', $pos);

        if (str_contains($p, 'president')) return 8;
        if (str_contains($p, 'ceo')) return 7;
        if (str_contains($p, 'cfo')) return 6;

        $l1 = ['cooking','driver','maid','operator','senior operator','support mat','tp man'];
        $l2 = ['foreman','leader','senior staff','senior technician','staff','technician'];
        $l3 = ['engineer','senior engineer','supervisor'];
        $l4 = ['assist manager','assistant manager','manager'];
        $l5 = ['deputy general manager','general manager'];

        foreach ($l1 as $x) if ($p === $x) return 1;
        foreach ($l2 as $x) if ($p === $x) return 2;
        foreach ($l3 as $x) if ($p === $x) return 3;
        foreach ($l4 as $x) if ($p === $x) return 4;
        foreach ($l5 as $x) if ($p === $x) return 5;

        if (str_contains($p, 'general manager') || str_contains($p, 'gm')) return 5;
        if (str_contains($p, 'manager')) return 4;
        if (str_contains($p, 'supervisor')) return 3;
        if (str_contains($p, 'engineer')) return 3;
        if (str_contains($p, 'technician') || str_contains($p, 'staff')) return 2;

        return 2;
    }

    protected function weights(int $level): array
    {
        $wAtt = [1=>50,2=>20,3=>10,4=>10,5=>0];
        $wIP  = [1=>50,2=>50,3=>40,4=>20,5=>10];

        if ($level >= 6) {
            return [
                'attendance' => 0,
                'individual' => 0,
                'deptOkr' => 0,
                'companyOkr' => 0,
                'okrReporting' => 0,
                'system' => 0,
                'bonus' => 0,
            ];
        }

        $base = [
            'attendance' => $wAtt[$level] ?? 0,
            'individual' => $wIP[$level] ?? 0,
            'deptOkr' => 0,
            'companyOkr' => 0,
            'okrReporting' => 0,
            'system' => 0,
            'bonus' => 0,
        ];

        if ($level === 1) {
            $base['bonus'] = 5;
        } elseif ($level === 2) {
            $base['deptOkr'] = 20; $base['system'] = 10; $base['bonus'] = 5;
        } elseif ($level === 3) {
            $base['deptOkr'] = 30; $base['system'] = 20; $base['bonus'] = 5;
        } elseif ($level === 4) {
            $base['deptOkr'] = 30; $base['companyOkr'] = 10; $base['okrReporting'] = 10; $base['system'] = 20; $base['bonus'] = 5;
        } elseif ($level === 5) {
            $base['deptOkr'] = 30; $base['companyOkr'] = 30; $base['okrReporting'] = 10; $base['system'] = 20; $base['bonus'] = 0;
        }

        return $base;
    }

    protected function grade(float $total, float $warning = 0, float $suspension = 0): array
    {
        $letter = ExportEmployee::gradeLetterFromScore($total) ?? 'F';
        $text = ExportEmployee::gradeTextFromLetter($letter) ?? 'Needs improvement';

        if ($suspension > 0) {
            if (in_array($letter, ['A','B','C'], true)) {
                $letter = 'D';
                $text = ExportEmployee::gradeTextFromLetter($letter) ?? 'Below expectation';
            }
            $text .= '(suspension)';
            return [$letter, $text];
        }

        if ($warning > 0) {
            if (in_array($letter, ['A','B'], true)) {
                $letter = 'C';
                $text = ExportEmployee::gradeTextFromLetter($letter) ?? 'Meets expectation';
            }
            $text .= '(warning)';
            return [$letter, $text];
        }

        return [$letter, $text];
    }

    protected function resolveRoleScores(ExportEmployee $row, string $role): array
    {
        $t = $row->getTable();

        if ($role === 'division') {
            $leadCols = [
                'division_score_leadership','division_score_leader',
                'div_score_leadership','div_score_leader',
            ];
            $attCols = [
                'division_score_attitude','division_score_attritude',
                'div_score_attitude','div_score_attritude',
            ];

            $lead = $this->pickFirstValue($row, $leadCols);
            $att  = $this->pickFirstValue($row, $attCols);

            return [$lead, $att];
        }

        $leadCols = [
            'supervisor_score_leadership','supervisor_score_leader',
            'sup_score_leadership','sup_score_leader',
        ];
        $attCols = [
            'supervisor_score_attitude','supervisor_score_attritude',
            'sup_score_attitude','sup_score_attritude',
        ];

        $lead = $this->pickFirstValue($row, $leadCols);
        $att  = $this->pickFirstValue($row, $attCols);

        if ($lead === null) {
            $lead = $this->pickFirstValue($row, ['score_leadership','score_leader','leadership']);
        }
        if ($att === null) {
            $att = $this->pickFirstValue($row, ['score_attitude','score_attritude','attitude','attritude']);
        }

        return [$lead, $att];
    }

    public function computeFromExport(ExportEmployee $row, string $role): array
    {
        $level = $this->detectLevel($row);
        $w = $this->weights($level);

        $base       = $this->pickFirstValue($row, ['attendance_total']) ?? 100.0;
        $sick       = $this->pickFirstValue($row, ['attendance_sick']) ?? 0.0;
        $personal   = $this->pickFirstValue($row, ['attendance_personal']) ?? 0.0;
        $maternity  = $this->pickFirstValue($row, ['attendance_maternity']) ?? 0.0;
        $ordain     = $this->pickFirstValue($row, ['attendance_ordain']) ?? 0.0;
        $late       = $this->pickFirstValue($row, ['attendance_late']) ?? 0.0;
        $absent     = $this->pickFirstValue($row, ['attendance_absent','attendance_lwop','attendance_leave_without_pay']) ?? 0.0;
        $warning    = $this->pickFirstValue($row, ['attendance_warning']) ?? 0.0;
        $suspension = $this->pickFirstValue($row, ['attendance_suspension']) ?? 0.0;

        $deduct_absent   = $absent * 3.0;
        $deduct_sick     = $sick * 1.0;
        $deduct_personal = $personal * 1.0;
        $deduct_late     = $late * 0.25;
        $totalDeduct     = $deduct_absent + $deduct_sick + $deduct_personal + $deduct_late;

        $raw = max(0.0, $base - $totalDeduct);
        $attendancePoints = ($w['attendance'] > 0 && $base > 0) ? (($raw / $base) * $w['attendance']) : 0.0;
        $rawPercent = ($base > 0) ? (($raw / $base) * 100.0) : 0.0;

        $asakaiPercent   = $this->pickFirstValue($row, ['asakai_attend_percent']) ?? null;
        $redAlertPercent = $this->pickFirstValue($row, ['redalert_attend_percent']) ?? null;

        $teamworkScore = $this->pickFirstValue($row, ['score_teamwork','ip_teamwork','teamwork']);
        $commScore     = $this->pickFirstValue($row, ['score_communication','ip_communication','communication','comm']);
        $planningScore = $this->pickFirstValue($row, ['score_planning','ip_planning','planning']);
        $ownerScore    = $this->pickFirstValue($row, ['score_ownership','ip_ownership','ownership','owner']);
        $problemScore  = $this->pickFirstValue($row, ['score_problem_solving','score_problem','ip_problem','problem_solving','problem']);

        [$leaderScore, $attitudeScore] = $this->resolveRoleScores($row, $role);

        $ipItems = [
            ['id'=>'teamwork','label'=>__('app.assess_ip_topic_teamwork'),'score'=>$teamworkScore],
            ['id'=>'comm','label'=>__('app.assess_ip_topic_comm'),'score'=>$commScore],
            ['id'=>'leader','label'=>__('app.assess_ip_topic_leader'),'score'=>$leaderScore],
            ['id'=>'attitude','label'=>__('app.assess_ip_topic_attitude'),'score'=>$attitudeScore],
            ['id'=>'planning','label'=>__('app.assess_ip_topic_planning'),'score'=>$planningScore],
            ['id'=>'owner','label'=>__('app.assess_ip_topic_owner'),'score'=>$ownerScore],
            ['id'=>'problem','label'=>__('app.assess_ip_topic_problem'),'score'=>$problemScore],
        ];

        $ipFullScore = 0.0;
        $ipTotalScore = 0.0;
        foreach ($ipItems as $t) {
            if ($t['score'] !== null) {
                $ipTotalScore += (float)$t['score'];
                $ipFullScore += 10.0;
            }
        }

        $ipPercent = null;
        $ipWeightedScore = null;
        if ($ipFullScore > 0) {
            $ipPercent = ($ipTotalScore / $ipFullScore) * 100.0;
            $ipWeightedScore = ($ipTotalScore / $ipFullScore) * $w['individual'];
        }

        $deptOkrScore    = $this->pickFirstValue($row, ['score_dept_okr']) ?? 0.0;
        $companyOkrScore = $this->pickFirstValue($row, ['score_company_okr']) ?? 0.0;
        $okrReportScore  = $this->pickFirstValue($row, ['score_okr_reporting']) ?? 0.0;
        $systemSmbrScore = $this->pickFirstValue($row, ['score_system_smbr']) ?? 0.0;
        $bonusRaw        = $this->pickFirstValue($row, ['score_bonus']) ?? 0.0;

        $deptOkrWeighted    = $w['deptOkr'] > 0 ? ($deptOkrScore / 10.0) * $w['deptOkr'] : 0.0;
        $companyOkrWeighted = $w['companyOkr'] > 0 ? ($companyOkrScore / 10.0) * $w['companyOkr'] : 0.0;
        $okrReportWeighted  = $w['okrReporting'] > 0 ? ($okrReportScore / 10.0) * $w['okrReporting'] : 0.0;
        $systemWeighted     = $w['system'] > 0 ? ($systemSmbrScore / 5.0) * $w['system'] : 0.0;

        $otherPoints = $deptOkrWeighted + $companyOkrWeighted + $okrReportWeighted + $systemWeighted;

        $bonusPts = 0.0;
        if ($w['bonus'] > 0) {
            $bonusPts = max(-(float)$w['bonus'], min((float)$w['bonus'], (float)$bonusRaw));
        }

        $maxBaseWeight = $w['attendance'] + $w['individual'] + $w['deptOkr'] + $w['companyOkr'] + $w['okrReporting'] + $w['system'];
        $maxWithBonus = $maxBaseWeight + $w['bonus'];

        $totalBaseNoBonus = $attendancePoints + ($ipWeightedScore ?? 0.0) + $otherPoints;
        $totalWithBonus = $totalBaseNoBonus + $bonusPts;

        $gradeLetter = null;
        $gradeText = null;

        if ($level >= 6) {
            $totalWithBonus = null;
        } else {
            [$gradeLetter, $gradeText] = $this->grade((float)$totalWithBonus, (float)$warning, (float)$suspension);
        }

        $summaryLines = [];
        if ($w['attendance'] > 0) $summaryLines[] = ['id'=>'attendance','label'=>__('app.assess_weight_attendance'),'value'=>$w['attendance']];
        if ($w['individual'] > 0) $summaryLines[] = ['id'=>'individual','label'=>__('app.assess_weight_individual'),'value'=>$w['individual']];
        if ($w['deptOkr'] > 0) $summaryLines[] = ['id'=>'dept_okr','label'=>__('app.assess_weight_dept_okr'),'value'=>$w['deptOkr']];
        if ($w['companyOkr'] > 0) $summaryLines[] = ['id'=>'company_okr','label'=>__('app.assess_weight_company_okr'),'value'=>$w['companyOkr']];
        if ($w['okrReporting'] > 0) $summaryLines[] = ['id'=>'okr_reporting','label'=>__('app.assess_weight_okr_reporting'),'value'=>$w['okrReporting']];
        if ($w['system'] > 0) $summaryLines[] = ['id'=>'system','label'=>__('app.assess_weight_system'),'value'=>$w['system']];
        if ($w['bonus'] > 0) $summaryLines[] = ['id'=>'bonus','label'=>__('app.assess_weight_bonus'),'value'=>$w['bonus']];

        return [
            'role' => $role,
            'level' => $level,

            'weightAttendance' => $w['attendance'],
            'weightIndividual' => $w['individual'],
            'weightDeptOkr' => $w['deptOkr'],
            'weightCompanyOkr' => $w['companyOkr'],
            'weightOkrReporting' => $w['okrReporting'],
            'weightSystem' => $w['system'],
            'weightBonus' => $w['bonus'],

            'base' => $base,
            'sick' => $sick,
            'personal' => $personal,
            'maternity' => $maternity,
            'ordain' => $ordain,
            'late' => $late,
            'absent' => $absent,
            'warning' => $warning,
            'suspension' => $suspension,

            'deduct_absent' => $deduct_absent,
            'deduct_sick' => $deduct_sick,
            'deduct_personal' => $deduct_personal,
            'deduct_late' => $deduct_late,
            'totalDeduct' => $totalDeduct,
            'raw' => $raw,
            'rawPercent' => $rawPercent,
            'attendancePoints' => $attendancePoints,

            'asakaiPercent' => $asakaiPercent,
            'redAlertPercent' => $redAlertPercent,

            'leaderScore' => $leaderScore,
            'attitudeScore' => $attitudeScore,

            'ipItems' => $ipItems,
            'ipFullScore' => $ipFullScore,
            'ipTotalScore' => $ipTotalScore,
            'ipPercent' => $ipPercent,
            'ipWeightedScore' => $ipWeightedScore,

            'deptOkrScore' => $deptOkrScore,
            'companyOkrScore' => $companyOkrScore,
            'okrReportScore' => $okrReportScore,
            'systemSmbrScore' => $systemSmbrScore,
            'bonusScore' => $bonusPts,

            'deptOkrWeighted' => $deptOkrWeighted,
            'companyOkrWeighted' => $companyOkrWeighted,
            'okrReportWeighted' => $okrReportWeighted,
            'systemWeighted' => $systemWeighted,
            'otherPoints' => $otherPoints,

            'maxBaseWeight' => $maxBaseWeight,
            'maxWithBonus' => $maxWithBonus,

            'totalBaseNoBonus' => $totalBaseNoBonus,
            'totalWithBonus' => $totalWithBonus,

            'gradeLetter' => $gradeLetter,
            'gradeText' => $gradeText,

            'summaryLines' => $summaryLines,
        ];
    }

    protected function firstExisting(string $table, array $cols): ?string
    {
        foreach ($cols as $c) {
            if ($this->hasCol($table, $c)) return $c;
        }
        return null;
    }

    public function applyComputedToExport(ExportEmployee $row, array $calc, string $role): void
    {
        $t = $row->getTable();

        if ($this->hasCol($t, 'position_level') && empty($row->position_level) && isset($calc['level'])) {
            $row->position_level = (int)$calc['level'];
        }

        $final = $calc['totalWithBonus'] ?? null;
        $ipSum = $calc['ipTotalScore'] ?? null;
        $ipPercent = $calc['ipPercent'] ?? null;
        $ipWeighted = $calc['ipWeightedScore'] ?? null;
        $gLetter = $calc['gradeLetter'] ?? null;
        $gText = $calc['gradeText'] ?? null;

        if ($role === 'division') {
            $finalCols = ['division_final_score','div_final_score','division_score_final'];
            $glCols = ['division_grade','division_grade_letter','div_grade_letter'];
            $gtCols = ['division_grade_text','div_grade_text','division_grade_note','div_grade_note'];
            $ipSumCols = ['division_ip_sum','div_ip_sum'];
            $ipPercentCols = ['division_ip_percent','div_ip_percent'];
            $ipWeightedCols = ['division_ip_weighted','div_ip_weighted'];

            $finalCol = $this->firstExisting($t, $finalCols);
            $glCol = $this->firstExisting($t, $glCols);
            $gtCol = $this->firstExisting($t, $gtCols);
            $ipSumCol = $this->firstExisting($t, $ipSumCols);
            $ipPercentCol = $this->firstExisting($t, $ipPercentCols);
            $ipWeightedCol = $this->firstExisting($t, $ipWeightedCols);

            if ($finalCol && $final !== null) $row->{$finalCol} = round((float)$final, 2);
            if ($glCol) $row->{$glCol} = $gLetter;
            if ($gtCol) $row->{$gtCol} = $gText;

            if ($ipSumCol && $ipSum !== null) $row->{$ipSumCol} = round((float)$ipSum, 2);
            if ($ipPercentCol && $ipPercent !== null) $row->{$ipPercentCol} = round((float)$ipPercent, 2);
            if ($ipWeightedCol && $ipWeighted !== null) $row->{$ipWeightedCol} = round((float)$ipWeighted, 2);

            if (!$finalCol && $this->hasCol($t, 'final_score') && $final !== null) {
                $row->final_score = round((float)$final, 2);
                if ($this->hasCol($t, 'grade_letter')) $row->grade_letter = $gLetter;
                if ($this->hasCol($t, 'grade_text')) $row->grade_text = $gText;
                if ($this->hasCol($t, 'ip_sum') && $ipSum !== null) $row->ip_sum = round((float)$ipSum, 2);
                if ($this->hasCol($t, 'ip_percent') && $ipPercent !== null) $row->ip_percent = round((float)$ipPercent, 2);
                if ($this->hasCol($t, 'ip_weighted') && $ipWeighted !== null) $row->ip_weighted = round((float)$ipWeighted, 2);
            }

            return;
        }

        $finalCols = ['supervisor_final_score','sup_final_score','supervisor_score_final','sup_score_final'];
        $glCols = ['supervisor_grade','supervisor_grade_letter','sup_grade_letter'];
        $gtCols = ['supervisor_grade_text','sup_grade_text','supervisor_grade_note','sup_grade_note'];
        $ipSumCols = ['supervisor_ip_sum','sup_ip_sum'];
        $ipPercentCols = ['supervisor_ip_percent','sup_ip_percent'];
        $ipWeightedCols = ['supervisor_ip_weighted','sup_ip_weighted'];

        $finalCol = $this->firstExisting($t, $finalCols);
        $glCol = $this->firstExisting($t, $glCols);
        $gtCol = $this->firstExisting($t, $gtCols);
        $ipSumCol = $this->firstExisting($t, $ipSumCols);
        $ipPercentCol = $this->firstExisting($t, $ipPercentCols);
        $ipWeightedCol = $this->firstExisting($t, $ipWeightedCols);

        if ($finalCol && $final !== null) $row->{$finalCol} = round((float)$final, 2);
        if ($glCol) $row->{$glCol} = $gLetter;
        if ($gtCol) $row->{$gtCol} = $gText;

        if ($ipSumCol && $ipSum !== null) $row->{$ipSumCol} = round((float)$ipSum, 2);
        if ($ipPercentCol && $ipPercent !== null) $row->{$ipPercentCol} = round((float)$ipPercent, 2);
        if ($ipWeightedCol && $ipWeighted !== null) $row->{$ipWeightedCol} = round((float)$ipWeighted, 2);

        if (!$finalCol && $this->hasCol($t, 'final_score') && $final !== null) {
            $row->final_score = round((float)$final, 2);
            if ($this->hasCol($t, 'grade_letter')) $row->grade_letter = $gLetter;
            if ($this->hasCol($t, 'grade_text')) $row->grade_text = $gText;
            if ($this->hasCol($t, 'ip_sum') && $ipSum !== null) $row->ip_sum = round((float)$ipSum, 2);
            if ($this->hasCol($t, 'ip_percent') && $ipPercent !== null) $row->ip_percent = round((float)$ipPercent, 2);
            if ($this->hasCol($t, 'ip_weighted') && $ipWeighted !== null) $row->ip_weighted = round((float)$ipWeighted, 2);
        }
    }

    public function computeAllInCycle(int $cycleId): void
    {
        if ($cycleId <= 0) return;
        if (!Schema::hasTable('export_employees')) return;

        $q = ExportEmployee::query()->where('cycle_id', $cycleId);

        $hasId = Schema::hasColumn('export_employees', 'id');

        $handler = function ($rows) {
            foreach ($rows as $row) {
                $calcSup = $this->computeFromExport($row, 'supervisor');
                $this->applyComputedToExport($row, $calcSup, 'supervisor');

                $calcDiv = $this->computeFromExport($row, 'division');
                $this->applyComputedToExport($row, $calcDiv, 'division');

                $row->save();
            }
        };

        if ($hasId && method_exists($q, 'chunkById')) {
            $q->orderBy('id')->chunkById(500, $handler, 'id');
        } else {
            $q->orderBy('employee_code')->chunk(500, $handler);
        }
    }
}
