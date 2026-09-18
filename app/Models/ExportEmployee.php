<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

use App\Models\Cycle;
use App\Models\Employee;
use App\Models\AppUser;
use App\Models\SelfEmployee;

class ExportEmployee extends Model
{
    use HasFactory;

    protected $table = 'export_employees';

    public const LEVEL_CFO        = 6;
    public const LEVEL_CEO        = 7;
    public const LEVEL_PRESIDENT  = 8;

    public const GRADE_TEXT_MAP = [
        'A' => 'Outstanding',
        'B' => 'Exceeds expectation',
        'C' => 'Meets expectation',
        'D' => 'Below expectation',
        'F' => 'Needs impovement',
    ];

    protected $fillable = [
        'cycle_id',

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
        'position_level',

        'assessment_status',

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
        'score_leadership',
        'score_attitude',
        'score_planning',
        'score_ownership',
        'score_problem_solving',
        'score_dept_okr',
        'score_company_okr',
        'score_okr_reporting',
        'score_system_smbr',
        'score_bonus',

        'supervisor_score_leadership',
        'supervisor_score_attitude',
        'supervisor_final_score',
        'supervisor_grade',
        'supervisor_grade_text',

        'division_score_leadership',
        'division_score_attitude',
        'division_final_score',
        'division_grade',
        'division_grade_text',

        'q_percent',
    ];

    protected $casts = [
        'cycle_id'           => 'integer',
        'position_level'     => 'integer',
        'assessment_status'  => 'string',

        'attendance_total'      => 'float',
        'attendance_sick'       => 'float',
        'attendance_personal'   => 'float',
        'attendance_maternity'  => 'float',
        'attendance_ordain'     => 'float',
        'attendance_late'       => 'float',
        'attendance_absent'     => 'float',
        'attendance_warning'    => 'float',
        'attendance_suspension' => 'float',

        'score_teamwork'        => 'float',
        'score_communication'   => 'float',
        'score_leadership'      => 'float',
        'score_attitude'        => 'float',
        'score_planning'        => 'float',
        'score_ownership'       => 'float',
        'score_problem_solving' => 'float',
        'score_dept_okr'        => 'float',
        'score_company_okr'     => 'float',
        'score_okr_reporting'   => 'float',
        'score_system_smbr'     => 'float',
        'score_bonus'           => 'float',

        'supervisor_score_leadership' => 'float',
        'supervisor_score_attitude'   => 'float',
        'supervisor_final_score'      => 'float',
        'supervisor_grade'            => 'string',
        'supervisor_grade_text'       => 'string',

        'division_score_leadership'   => 'float',
        'division_score_attitude'     => 'float',
        'division_final_score'        => 'float',
        'division_grade'              => 'string',
        'division_grade_text'         => 'string',

        'q_percent' => 'float',
    ];

    protected static array $colsCache = [];

    protected function colsCached(): array
    {
        $t = $this->getTable();
        if (!isset(self::$colsCache[$t])) {
            self::$colsCache[$t] = Schema::hasTable($t) ? Schema::getColumnListing($t) : [];
        }
        return self::$colsCache[$t];
    }

    protected function hasCol(string $col): bool
    {
        return in_array($col, $this->colsCached(), true);
    }

    protected static function booted()
    {
        static::saving(function (ExportEmployee $row) {
            $row->syncSupervisorLinkLA();

            if ($row->isNoAssessmentLevel()) {
                $row->assessment_status = '0/0';
                return;
            }

            $row->recalcAssessmentStatus();
        });
    }

    public function cycle() { return $this->belongsTo(Cycle::class, 'cycle_id'); }
    public function employee() { return $this->belongsTo(Employee::class, 'employee_code', 'employee_code'); }
    public function user() { return $this->belongsTo(AppUser::class, 'employee_code', 'username'); }
    public function selfEmployee() { return $this->hasOne(SelfEmployee::class, 'employee_code', 'employee_code'); }

    public function scopeInCycle($query, ?int $cycleId)
    {
        if (!$cycleId) return $query;
        return $query->where('cycle_id', $cycleId);
    }

    protected function normId($v): string
    {
        $s = trim((string)($v ?? ''));
        $s = preg_replace('/\s+/', '', $s) ?? $s;
        return $s;
    }

    protected function numOrNull($v): ?float
    {
        if ($v === null) return null;
        if (is_int($v) || is_float($v)) return (float)$v;

        $s = trim((string)$v);
        if ($s === '') return null;

        $k = strtolower($s);
        $k = preg_replace('/\s+/', '', $k) ?? $k;
        if (in_array($k, ['na','n/a','n\\a','-','--','–','—'], true)) return null;

        $s = str_replace([',',' '], '', $s);
        if (!is_numeric($s)) return null;

        return (float)$s;
    }

    public function isNoAssessmentLevel(): bool
    {
        return in_array((int) $this->position_level, [
            self::LEVEL_CFO,
            self::LEVEL_CEO,
            self::LEVEL_PRESIDENT,
        ], true);
    }

    protected function syncSupervisorLinkLA(): void
    {
        if (!$this->hasCol('score_leadership') || !$this->hasCol('score_attitude')) return;
        if (!$this->hasCol('supervisor_score_leadership') || !$this->hasCol('supervisor_score_attitude')) return;

        $sl = $this->numOrNull($this->attributes['score_leadership'] ?? null);
        $sa = $this->numOrNull($this->attributes['score_attitude'] ?? null);
        $ssl = $this->numOrNull($this->attributes['supervisor_score_leadership'] ?? null);
        $ssa = $this->numOrNull($this->attributes['supervisor_score_attitude'] ?? null);

        if ($ssl === null && $sl !== null) $this->attributes['supervisor_score_leadership'] = $sl;
        if ($sl === null && $ssl !== null) $this->attributes['score_leadership'] = $ssl;

        if ($ssa === null && $sa !== null) $this->attributes['supervisor_score_attitude'] = $sa;
        if ($sa === null && $ssa !== null) $this->attributes['score_attitude'] = $ssa;
    }

    public function requiredAssessmentsCount(): int
    {
        if ($this->isNoAssessmentLevel()) return 0;

        $sup = $this->normId($this->sup_id);
        $div = $this->normId($this->div_mgr_id);

        $roles = [];

        if ($sup !== '') {
            $roles[] = 'supervisor';
        }

        if ($div !== '' && $div !== $sup) {
            $roles[] = 'division';
        }

        if (empty($roles)) return 1;

        return count(array_unique($roles));
    }

    protected function supervisorDoneByLA(): bool
    {
        $lead = $this->numOrNull($this->attributes['score_leadership'] ?? null);
        if ($lead === null) $lead = $this->numOrNull($this->attributes['supervisor_score_leadership'] ?? null);

        $att = $this->numOrNull($this->attributes['score_attitude'] ?? null);
        if ($att === null) $att = $this->numOrNull($this->attributes['supervisor_score_attitude'] ?? null);

        return ($lead !== null && $att !== null);
    }

    protected function divisionDoneByLA(): bool
    {
        $lead = $this->numOrNull($this->attributes['division_score_leadership'] ?? null);
        $att  = $this->numOrNull($this->attributes['division_score_attitude'] ?? null);
        return ($lead !== null && $att !== null);
    }

    public function completedAssessmentsCount(): int
    {
        if ($this->isNoAssessmentLevel()) return 0;

        $required = $this->requiredAssessmentsCount();

        $sup = $this->normId($this->sup_id);
        $div = $this->normId($this->div_mgr_id);

        $hasSup = ($sup !== '') || $required === 1;
        $hasDivReal = ($div !== '' && $div !== $sup);
        $sameAssessor = ($sup !== '' && $div !== '' && $sup === $div);

        $supDone = $this->supervisorDoneByLA();
        $divDone = $this->divisionDoneByLA();

        if ($required === 1 && $sameAssessor) {
            return ($supDone || $divDone) ? 1 : 0;
        }

        $done = 0;

        if ($hasSup && $supDone) $done++;
        if ($hasDivReal && $divDone) $done++;

        if ($done > $required) $done = $required;
        return $done;
    }

    public function recalcAssessmentStatus(): void
    {
        if ($this->isNoAssessmentLevel()) {
            $this->assessment_status = '0/0';
            return;
        }

        $required  = $this->requiredAssessmentsCount();
        $completed = $this->completedAssessmentsCount();

        if ($required <= 0) {
            $this->assessment_status = '0/0';
            return;
        }

        if ($completed > $required) $completed = $required;

        $this->assessment_status = $completed . '/' . $required;
    }

    public static function gradeLetterFromScore($score): ?string
    {
        if ($score === null || $score === '') return null;
        if (!is_numeric($score)) return null;

        $v = (float)$score;

        if ($v >= 95) return 'A';
        if ($v >= 85) return 'B';
        if ($v >= 75) return 'C';
        if ($v >= 60) return 'D';
        return 'F';
    }

    public static function gradeTextFromLetter($letter): ?string
    {
        $g = strtoupper(trim((string)$letter));
        if ($g === '') return null;
        return self::GRADE_TEXT_MAP[$g] ?? null;
    }

    public function getSupervisorGradeAttribute($value)
    {
        $v = trim((string)$value);
        if ($v !== '') return $v;

        $s = $this->attributes['supervisor_final_score'] ?? null;
        return self::gradeLetterFromScore($s);
    }

    public function getSupervisorGradeTextAttribute($value)
    {
        $v = trim((string)$value);
        if ($v !== '') return $v;

        $g = $this->attributes['supervisor_grade'] ?? null;
        $t = self::gradeTextFromLetter($g);
        if ($t) return $t;

        $s = $this->attributes['supervisor_final_score'] ?? null;
        return self::gradeTextFromLetter(self::gradeLetterFromScore($s));
    }

    public function getDivisionGradeAttribute($value)
    {
        $v = trim((string)$value);
        if ($v !== '') return $v;

        $s = $this->attributes['division_final_score'] ?? null;
        return self::gradeLetterFromScore($s);
    }

    public function getDivisionGradeTextAttribute($value)
    {
        $v = trim((string)$value);
        if ($v !== '') return $v;

        $g = $this->attributes['division_grade'] ?? null;
        $t = self::gradeTextFromLetter($g);
        if ($t) return $t;

        $s = $this->attributes['division_final_score'] ?? null;
        return self::gradeTextFromLetter(self::gradeLetterFromScore($s));
    }

    public function setSupervisorFinalScoreAttribute($value): void
    {
        $this->attributes['supervisor_final_score'] = ($value === '' ? null : $value);

        $letter = self::gradeLetterFromScore($value);
        $this->attributes['supervisor_grade'] = $letter;
        $this->attributes['supervisor_grade_text'] = $letter ? self::gradeTextFromLetter($letter) : null;
    }

    public function setDivisionFinalScoreAttribute($value): void
    {
        $this->attributes['division_final_score'] = ($value === '' ? null : $value);

        $letter = self::gradeLetterFromScore($value);
        $this->attributes['division_grade'] = $letter;
        $this->attributes['division_grade_text'] = $letter ? self::gradeTextFromLetter($letter) : null;
    }

    public function setSupervisorGradeAttribute($value): void
    {
        $letter = strtoupper(trim((string)$value));
        $this->attributes['supervisor_grade'] = ($letter === '' ? null : $letter);
        $this->attributes['supervisor_grade_text'] = ($letter === '' ? null : self::gradeTextFromLetter($letter));
    }

    public function setDivisionGradeAttribute($value): void
    {
        $letter = strtoupper(trim((string)$value));
        $this->attributes['division_grade'] = ($letter === '' ? null : $letter);
        $this->attributes['division_grade_text'] = ($letter === '' ? null : self::gradeTextFromLetter($letter));
    }
}
