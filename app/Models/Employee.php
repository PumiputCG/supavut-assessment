<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\AppUser;

class Employee extends Model
{
    use HasFactory;

    protected $table = 'employees';

    public const LEVEL_OPERATOR   = 1;
    public const LEVEL_STAFF      = 2;
    public const LEVEL_SUPERVISOR = 3;
    public const LEVEL_MANAGER    = 4;
    public const LEVEL_GM         = 5;

    public const LEVEL_CFO        = 6;
    public const LEVEL_CEO        = 7;
    public const LEVEL_PRESIDENT  = 8;

    public const POSITION_LEVEL_MAP = [
        self::LEVEL_OPERATOR => [
            'cooking',
            'driver',
            'maid',
            'operator',
            'senior operator',
            'support mat',
            'tp man',
        ],
        self::LEVEL_STAFF => [
            'foreman',
            'leader',
            'senior staff',
            'senior technician',
            'staff',
            'technician',
        ],
        self::LEVEL_SUPERVISOR => [
            'engineer',
            'senior engineer',
            'supervisor',
        ],
        self::LEVEL_MANAGER => [
            'assist manager',
            'assistant manager',
            'manager',
        ],
        self::LEVEL_GM => [
            'deputy general manager',
            'general manager',
        ],
        self::LEVEL_CFO => [
            'chief financial officer',
            'cfo',
        ],
        self::LEVEL_CEO => [
            'chief executive officer',
            'ceo',
        ],
        self::LEVEL_PRESIDENT => [
            'president',
        ],
    ];

    protected $fillable = [
        'employee_code',
        'citizen_id',

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

        'division_score_leadership',
        'division_score_attitude',
    ];

    protected $casts = [
        'position_level' => 'integer',
        'citizen_id'     => 'string',

        'attendance_total'       => 'decimal:2',
        'attendance_sick'        => 'decimal:2',
        'attendance_personal'    => 'decimal:2',
        'attendance_maternity'   => 'decimal:2',
        'attendance_ordain'      => 'decimal:2',
        'attendance_late'        => 'decimal:2',
        'attendance_absent'      => 'decimal:2',
        'attendance_warning'     => 'decimal:2',
        'attendance_suspension'  => 'decimal:2',

        'score_teamwork'         => 'decimal:2',
        'score_communication'    => 'decimal:2',
        'score_leadership'       => 'decimal:2',
        'score_attitude'         => 'decimal:2',
        'score_planning'         => 'decimal:2',
        'score_ownership'        => 'decimal:2',
        'score_problem_solving'  => 'decimal:2',

        'score_dept_okr'         => 'decimal:2',
        'score_company_okr'      => 'decimal:2',
        'score_okr_reporting'    => 'decimal:2',
        'score_system_smbr'      => 'decimal:2',
        'score_bonus'            => 'decimal:2',

        'division_score_leadership' => 'decimal:2',
        'division_score_attitude'   => 'decimal:2',
    ];

    private static function isExcelNAString(string $u): bool
    {
        $u = strtoupper(trim($u));
        if ($u === '') return true;
        $u = preg_replace('/\s+/u', '', $u) ?? $u;

        return in_array($u, [
            'N/A', 'NA', 'N\\A',
            '#N/A', '#N/A!', '#NA', '#VALUE!',
            'NULL', 'NONE',
            '-', '--',
        ], true);
    }

    private static function normalizeExcelString($v): ?string
    {
        if ($v === null) return null;

        if (is_string($v)) {
            $t = trim(preg_replace('/\s+/', ' ', $v) ?? '');
            if ($t === '') return null;
            if (self::isExcelNAString($t)) return null;
            if (str_contains($t, '####')) return null;
            return $t;
        }

        if (is_int($v)) return (string) $v;
        if (is_float($v)) {
            if (abs($v - round($v)) < 0.0000001) return sprintf('%.0f', $v);
            return rtrim(rtrim(sprintf('%.10F', $v), '0'), '.');
        }

        return null;
    }

    private static function normalizeExcelInt($v): ?int
    {
        if ($v === null) return null;

        if (is_int($v)) return $v;
        if (is_float($v)) return (int) round($v);

        if (is_string($v)) {
            $t = trim($v);
            if ($t === '' || self::isExcelNAString($t)) return null;
            if (str_contains($t, '####')) return null;

            $t = str_replace([',', ' '], '', $t);
            if (is_numeric($t)) return (int) round((float) $t);
            return null;
        }

        return null;
    }

    private static function normalizeExcelDecimal($v, int $scale = 2): ?float
    {
        if ($v === null) return null;

        if (is_int($v) || is_float($v)) {
            return round((float) $v, $scale);
        }

        if (is_string($v)) {
            $t = trim($v);
            if ($t === '' || self::isExcelNAString($t)) return null;
            if (str_contains($t, '####')) return null;

            $t = self::toArabicDigits($t);
            $raw = str_replace(' ', '', $t);

            if (preg_match('/^\d+,\d+$/', $raw) && !str_contains($raw, '.')) {
                $raw = str_replace(',', '.', $raw);
            } else {
                $raw = str_replace(',', '', $raw);
            }

            if (!is_numeric($raw)) return null;

            return round((float) $raw, $scale);
        }

        return null;
    }

    private static function excelTextFields(): array
    {
        return [
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
        ];
    }

    private static function excelIntFields(): array
    {
        return [
            'position_level',
        ];
    }

    private static function excelDecimalFields(): array
    {
        return [
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

            'division_score_leadership',
            'division_score_attitude',
        ];
    }

    private static function toArabicDigits(string $s): string
    {
        $map = [
            '๐'=>'0','๑'=>'1','๒'=>'2','๓'=>'3','๔'=>'4','๕'=>'5','๖'=>'6','๗'=>'7','๘'=>'8','๙'=>'9',
            '໐'=>'0','໑'=>'1','໒'=>'2','໓'=>'3','໔'=>'4','໕'=>'5','໖'=>'6','໗'=>'7','໘'=>'8','໙'=>'9',
        ];
        return strtr($s, $map);
    }

    public function setCitizenIdAttribute($value): void
    {
        if (is_float($value)) {
            $value = sprintf('%.0f', $value);
        } elseif (is_int($value)) {
            $value = (string) $value;
        }

        $v = trim((string) $value);

        if ($v === '' || str_contains($v, '#')) {
            $this->attributes['citizen_id'] = null;
            return;
        }

        if (str_starts_with($v, 'eyJ')) {
            $this->attributes['citizen_id'] = null;
            return;
        }

        $v = self::toArabicDigits($v);
        $digits = preg_replace('/\D+/', '', $v) ?? '';
        $digits = trim($digits);

        $this->attributes['citizen_id'] = ($digits === '') ? null : $digits;
    }

    public function appUser()
    {
        return $this->belongsTo(AppUser::class, 'employee_code', 'username');
    }

    public function user()
    {
        return $this->appUser();
    }

    public static function normalizePosition(?string $position): ?string
    {
        if ($position === null) return null;

        $normalized = strtolower(trim(preg_replace('/\s+/', ' ', $position)));
        return $normalized === '' ? null : $normalized;
    }

    public static function detectPositionLevel(?string $position): ?int
    {
        $normalized = self::normalizePosition($position);
        if ($normalized === null) return null;

        foreach (self::POSITION_LEVEL_MAP as $level => $titles) {
            if (in_array($normalized, $titles, true)) {
                return (int) $level;
            }
        }
        return null;
    }

    protected static function booted()
    {
        static::saving(function (Employee $employee) {
            foreach (self::excelTextFields() as $f) {
                $employee->{$f} = self::normalizeExcelString($employee->{$f});
            }

            foreach (self::excelIntFields() as $f) {
                $employee->{$f} = self::normalizeExcelInt($employee->{$f});
            }

            foreach (self::excelDecimalFields() as $f) {
                $employee->{$f} = self::normalizeExcelDecimal($employee->{$f}, 2);
            }

            if (empty($employee->position_level) && !empty($employee->position)) {
                $employee->position_level = self::detectPositionLevel($employee->position);
            }
        });
    }
}
