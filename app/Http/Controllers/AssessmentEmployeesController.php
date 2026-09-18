<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Illuminate\Validation\ValidationException;

use App\Models\Cycle;
use App\Models\Employee;
use App\Models\ExportEmployee;
use App\Services\AssessmentScoreCalculator;

class AssessmentEmployeesController extends Controller
{
    protected function activeCycleOrLatest(): ?Cycle
    {
        $q = Cycle::query()->orderByDesc('id');

        if (Schema::hasColumn('cycles', 'is_active')) {
            $active = Cycle::query()->where('is_active', true)->orderByDesc('id')->first();
            if ($active) return $active;
        }

        if (Schema::hasColumn('cycles', 'status') && defined(Cycle::class . '::STATUS_OPEN')) {
            $open = Cycle::query()->where('status', Cycle::STATUS_OPEN)->orderByDesc('id')->first();
            if ($open) return $open;
        }

        return $q->first();
    }

    protected function normalizeCode($v): string
    {
        $s = trim((string)($v ?? ''));
        $s = preg_replace('/\s+/', '', $s) ?? $s;
        return $s;
    }

    protected function currentUserCode(): ?string
    {
        $u = Auth::user();
        if (!$u) return null;

        $raw = $u->username ?? $u->employee_code ?? $u->employeeCode ?? null;
        $code = $this->normalizeCode($raw);
        return $code !== '' ? $code : null;
    }

    protected function isSup(Employee $employee, string $myCode): bool
    {
        if (!Schema::hasColumn('employees', 'sup_id')) return false;
        return $this->normalizeCode($employee->sup_id) === $myCode;
    }

    protected function isDiv(Employee $employee, string $myCode): bool
    {
        if (!Schema::hasColumn('employees', 'div_mgr_id')) return false;
        return $this->normalizeCode($employee->div_mgr_id) === $myCode;
    }

    protected function resolveRoleFor(Employee $employee, string $myCode): ?string
    {
        if ($this->isSup($employee, $myCode)) return 'supervisor';
        if ($this->isDiv($employee, $myCode)) return 'division';
        return null;
    }

    protected function pickFirstExistingColumn(string $table, array $candidates): ?string
    {
        foreach ($candidates as $c) {
            if (Schema::hasColumn($table, $c)) return $c;
        }
        return null;
    }

    protected function avatarUrlFromPath(?string $path): ?string
    {
        $p = trim((string)($path ?? ''));
        if ($p === '') return null;

        if (preg_match('~^https?://~i', $p)) return $p;

        $p = ltrim($p, '/');
        if (str_starts_with($p, 'storage/')) return asset($p);

        return asset('storage/' . $p);
    }

    protected function avatarUrlForEmployee(Employee $employee): string
    {
        $default = asset('images/default-avatar.png');

        $empCandidates = [
            $employee->profile_picture ?? null,
            $employee->profile_photo ?? null,
            $employee->profile_image ?? null,
            $employee->photo ?? null,
            $employee->avatar ?? null,
            $employee->image ?? null,
            $employee->picture ?? null,
        ];

        foreach ($empCandidates as $c) {
            $u = $this->avatarUrlFromPath($c);
            if ($u) return $u;
        }

        if (method_exists($employee, 'appUser')) {
            $u = $employee->appUser;
            if ($u) {
                $pic = $u->profile_picture ?? $u->avatar ?? $u->photo ?? $u->image ?? null;
                $uu = $this->avatarUrlFromPath($pic);
                if ($uu) return $uu;
            }
        }

        if (method_exists($employee, 'user')) {
            $u = $employee->user;
            if ($u) {
                $pic = $u->profile_picture ?? $u->avatar ?? $u->photo ?? $u->image ?? null;
                $uu = $this->avatarUrlFromPath($pic);
                if ($uu) return $uu;
            }
        }

        return $default;
    }

    protected function normalizeNullableScore($v): ?string
    {
        if ($v === null) return null;

        $s = trim((string)$v);
        if ($s === '') return null;

        $k = strtolower($s);
        $k = preg_replace('/\s+/', '', $k) ?? $k;

        if (in_array($k, ['na', 'n/a', 'n\\a', '-', '--', '–', '—'], true)) return null;

        return $s;
    }

    protected function rowHasAnyValue($row, array $cols): bool
    {
        foreach ($cols as $c) {
            $vv = $row->{$c} ?? null;
            if ($this->normalizeNullableScore($vv) !== null) return true;
        }
        return false;
    }

    protected function firstRequestKey(Request $request, array $keys): ?string
    {
        foreach ($keys as $k) {
            if ($request->exists($k)) return $k;
        }
        return null;
    }

    protected function setScoreColsForRole(ExportEmployee $ex, string $role, ?float $leader, ?float $attitude): void
    {
        $t = $ex->getTable();

        $baseLeadCols = [
            'score_leadership',
            'score_leader',
            'leadership',
        ];

        $baseAttCols = [
            'score_attitude',
            'score_attritude',
            'attitude',
            'attritude',
        ];

        if ($role === 'division') {
            $leadCols = [
                'division_score_leadership',
                'division_score_leader',
                'div_score_leadership',
                'div_score_leader',
            ];
            $attCols = [
                'division_score_attitude',
                'division_score_attritude',
                'div_score_attitude',
                'div_score_attritude',
            ];
        } else {
            $leadCols = [
                'supervisor_score_leadership',
                'supervisor_score_leader',
                'sup_score_leadership',
                'sup_score_leader',
            ];
            $attCols = [
                'supervisor_score_attitude',
                'supervisor_score_attritude',
                'sup_score_attitude',
                'sup_score_attritude',
            ];
        }

        $wroteLead = false;
        foreach ($leadCols as $c) {
            if (Schema::hasColumn($t, $c)) {
                $ex->{$c} = $leader;
                $wroteLead = true;
            }
        }

        $wroteAtt = false;
        foreach ($attCols as $c) {
            if (Schema::hasColumn($t, $c)) {
                $ex->{$c} = $attitude;
                $wroteAtt = true;
            }
        }

        if ($role !== 'division') {
            foreach ($baseLeadCols as $c) {
                if (Schema::hasColumn($t, $c)) $ex->{$c} = $leader;
            }
            foreach ($baseAttCols as $c) {
                if (Schema::hasColumn($t, $c)) $ex->{$c} = $attitude;
            }
            return;
        }

        if (!$wroteLead) {
            foreach ($baseLeadCols as $c) {
                if (Schema::hasColumn($t, $c)) $ex->{$c} = $leader;
            }
        }

        if (!$wroteAtt) {
            foreach ($baseAttCols as $c) {
                if (Schema::hasColumn($t, $c)) $ex->{$c} = $attitude;
            }
        }
    }

    protected function readRoleScoreFromExport(ExportEmployee $ex, string $role, string $kind): ?float
    {
        $t = $ex->getTable();

        $supLead = ['supervisor_score_leadership','supervisor_score_leader','sup_score_leadership','sup_score_leader','score_leadership','score_leader','leadership'];
        $supAtt  = ['supervisor_score_attitude','supervisor_score_attritude','sup_score_attitude','sup_score_attritude','score_attitude','score_attritude','attitude','attritude'];

        $divLead = ['division_score_leadership','division_score_leader','div_score_leadership','div_score_leader'];
        $divAtt  = ['division_score_attitude','division_score_attritude','div_score_attitude','div_score_attritude'];

        $cands = [];
        if ($role === 'division') {
            $cands = ($kind === 'leadership') ? $divLead : $divAtt;
            if (empty($cands)) $cands = ($kind === 'leadership') ? ['score_leadership','leadership'] : ['score_attitude','attitude'];
        } else {
            $cands = ($kind === 'leadership') ? $supLead : $supAtt;
        }

        foreach ($cands as $c) {
            if (!Schema::hasColumn($t, $c)) continue;
            $vv = $this->normalizeNullableScore($ex->{$c} ?? null);
            if ($vv === null) continue;
            if (is_numeric($vv)) return (float)$vv;
        }

        return null;
    }

    protected function recalcIpForView(array $calc, ?float $leaderScore, ?float $attitudeScore): array
    {
        $weightIndividual = (int)($calc['weightIndividual'] ?? 0);

        $ipItems = $calc['ipItems'] ?? [];
        $total = 0.0;
        $count = 0;

        foreach ($ipItems as $it) {
            if (!is_array($it)) continue;
            $id = trim((string)($it['id'] ?? ''));
            if ($id === '') continue;

            if (in_array($id, ['leader','leadership'], true)) {
                if (is_numeric($leaderScore)) {
                    $total += (float)$leaderScore;
                    $count++;
                }
                continue;
            }
            if (in_array($id, ['attitude','attritude'], true)) {
                if (is_numeric($attitudeScore)) {
                    $total += (float)$attitudeScore;
                    $count++;
                }
                continue;
            }

            $s = $it['score'] ?? null;
            if (is_numeric($s)) {
                $total += (float)$s;
                $count++;
            }
        }

        $full = $count * 10.0;
        $percent = ($full > 0) ? (($total / $full) * 100.0) : 0.0;
        $weighted = ($full > 0) ? (($total / $full) * (float)$weightIndividual) : null;

        $calc['ipTotalScore'] = $total;
        $calc['ipFullScore'] = $full;
        $calc['ipPercent'] = $percent;
        $calc['ipWeightedScore'] = $weighted;

        return $calc;
    }

    protected function setFinalScoreColsForRole(ExportEmployee $ex, string $role, ?float $finalScore): void
    {
        if ($finalScore === null) return;

        $t = $ex->getTable();

        if ($role === 'division') {
            $cols = ['division_final_score','div_final_score','division_score_final'];
            foreach ($cols as $c) {
                if (Schema::hasColumn($t, $c)) $ex->{$c} = $finalScore;
            }
            return;
        }

        $cols = ['supervisor_final_score','sup_final_score','supervisor_score_final'];
        foreach ($cols as $c) {
            if (Schema::hasColumn($t, $c)) $ex->{$c} = $finalScore;
        }
        if (Schema::hasColumn($t, 'final_score')) $ex->final_score = $finalScore;
    }

    protected function safeOrderEmployees($query, string $col, string $dir = 'asc')
    {
        if (Schema::hasColumn('employees', $col)) {
            $query->orderBy($col, $dir);
        }
        return $query;
    }

    public function index()
    {
        $myCode = $this->currentUserCode();
        if (!$myCode) abort(403);

        $cycle = $this->activeCycleOrLatest();
        $cycleId = $cycle?->id;

        $with = [];
        if (method_exists(Employee::class, 'appUser')) $with[] = 'appUser';
        if (method_exists(Employee::class, 'user')) $with[] = 'user';

        $qSup = Employee::query();
        if (!empty($with)) $qSup->with($with);

        if (Schema::hasColumn('employees', 'sup_id')) {
            $qSup->where('sup_id', (string)$myCode);
        } else {
            $qSup->whereRaw('1=0');
        }

        if (Schema::hasColumn('employees', 'employee_code')) {
            $qSup->where('employee_code', '!=', (string)$myCode);
        }

        if (Schema::hasColumn('employees', 'assessment_status')) {
            $qSup->where('assessment_status', '!=', '0/0');
        }

        $this->safeOrderEmployees($qSup, 'department');
        $this->safeOrderEmployees($qSup, 'position');
        if (Schema::hasColumn('employees', 'employee_code')) $qSup->orderBy('employee_code');
        else $qSup->orderBy('id');

        $employeesSupervisor = $qSup->get();

        $qDiv = Employee::query();
        if (!empty($with)) $qDiv->with($with);

        if (Schema::hasColumn('employees', 'div_mgr_id')) {
            $qDiv->where('div_mgr_id', (string)$myCode);
        } else {
            $qDiv->whereRaw('1=0');
        }

        if (Schema::hasColumn('employees', 'employee_code')) {
            $qDiv->where('employee_code', '!=', (string)$myCode);
        }

        if (Schema::hasColumn('employees', 'assessment_status')) {
            $qDiv->where('assessment_status', '!=', '0/0');
        }

        if (Schema::hasColumn('employees', 'sup_id')) {
            $qDiv->where(function ($qq) use ($myCode) {
                $qq->whereNull('sup_id')->orWhere('sup_id', '!=', (string)$myCode);
            });
        }

        if (Schema::hasColumn('employees', 'employee_code')) {
            $excludeCodes = $employeesSupervisor->pluck('employee_code')->filter()->map(fn($v) => (string)$v)->unique()->values()->all();
            if (!empty($excludeCodes)) $qDiv->whereNotIn('employee_code', $excludeCodes);
        } else {
            $excludeIds = $employeesSupervisor->pluck('id')->filter()->unique()->values()->all();
            if (!empty($excludeIds)) $qDiv->whereNotIn('id', $excludeIds);
        }

        $this->safeOrderEmployees($qDiv, 'department');
        $this->safeOrderEmployees($qDiv, 'position');
        if (Schema::hasColumn('employees', 'employee_code')) $qDiv->orderBy('employee_code');
        else $qDiv->orderBy('id');

        $employeesDivision = $qDiv->get();

        $supScores = [];
        $divScores = [];
        $statusMap = [];

        $supHasScoreMap = [];
        $divHasScoreMap = [];

        if ($cycleId && Schema::hasTable('export_employees')) {
            $codes = collect()
                ->merge($employeesSupervisor->pluck('employee_code'))
                ->merge($employeesDivision->pluck('employee_code'))
                ->filter()
                ->map(fn($v) => (string)$v)
                ->unique()
                ->values()
                ->all();

            if (!empty($codes) && Schema::hasColumn('export_employees', 'cycle_id') && Schema::hasColumn('export_employees', 'employee_code')) {
                $supFinalCol = $this->pickFirstExistingColumn('export_employees', [
                    'supervisor_final_score', 'sup_final_score', 'supervisor_score_final', 'final_score'
                ]);

                $divFinalCol = $this->pickFirstExistingColumn('export_employees', [
                    'division_final_score', 'div_final_score', 'division_score_final'
                ]);

                $statusCol = $this->pickFirstExistingColumn('export_employees', [
                    'assessment_status', 'assess_status'
                ]);

                $supLeadCols = [];
                foreach (['score_leadership','supervisor_score_leadership','supervisor_score_leader','sup_score_leadership','sup_score_leader'] as $c) {
                    if (Schema::hasColumn('export_employees', $c)) $supLeadCols[] = $c;
                }
                $supAttCols = [];
                foreach (['score_attitude','score_attritude','supervisor_score_attitude','supervisor_score_attritude','sup_score_attitude','sup_score_attritude'] as $c) {
                    if (Schema::hasColumn('export_employees', $c)) $supAttCols[] = $c;
                }

                $divLeadCols = [];
                foreach (['division_score_leadership','division_score_leader','div_score_leadership','div_score_leader'] as $c) {
                    if (Schema::hasColumn('export_employees', $c)) $divLeadCols[] = $c;
                }
                $divAttCols = [];
                foreach (['division_score_attitude','division_score_attritude','div_score_attitude','div_score_attritude'] as $c) {
                    if (Schema::hasColumn('export_employees', $c)) $divAttCols[] = $c;
                }

                $selectCols = ['employee_code'];
                if ($supFinalCol) $selectCols[] = $supFinalCol;
                if ($divFinalCol && !in_array($divFinalCol, $selectCols, true)) $selectCols[] = $divFinalCol;
                if ($statusCol && !in_array($statusCol, $selectCols, true)) $selectCols[] = $statusCol;

                foreach (array_merge($supLeadCols, $supAttCols, $divLeadCols, $divAttCols) as $c) {
                    if (!in_array($c, $selectCols, true)) $selectCols[] = $c;
                }

                $rows = ExportEmployee::query()
                    ->where('cycle_id', (int)$cycleId)
                    ->whereIn('employee_code', $codes)
                    ->get($selectCols);

                if ($supFinalCol) {
                    foreach ($rows as $r) {
                        $k = (string)$r->employee_code;
                        $v = $r->{$supFinalCol};
                        if ($v !== null && $v !== '') $supScores[$k] = is_numeric($v) ? (float)$v : $v;
                    }
                }

                if ($divFinalCol) {
                    foreach ($rows as $r) {
                        $k = (string)$r->employee_code;
                        $v = $r->{$divFinalCol};
                        if ($v !== null && $v !== '') $divScores[$k] = is_numeric($v) ? (float)$v : $v;
                    }
                }

                if ($statusCol) {
                    foreach ($rows as $r) {
                        $k = (string)$r->employee_code;
                        $v = $r->{$statusCol} ?? null;
                        if ($v !== null && $v !== '') $statusMap[$k] = trim((string)$v);
                    }
                }

                foreach ($rows as $r) {
                    $k = (string)$r->employee_code;

                    $supHasLead = $this->rowHasAnyValue($r, $supLeadCols);
                    $supHasAtt  = $this->rowHasAnyValue($r, $supAttCols);
                    $supHasScoreMap[$k] = ($supHasLead && $supHasAtt);

                    $divHasLead = $this->rowHasAnyValue($r, $divLeadCols);
                    $divHasAtt  = $this->rowHasAnyValue($r, $divAttCols);
                    $divHasScoreMap[$k] = ($divHasLead && $divHasAtt);
                }
            }
        }

        return view('assessment.employees', [
            'activeCycleId' => $cycleId,
            'employeesSupervisor' => $employeesSupervisor,
            'employeesDivision' => $employeesDivision,
            'supScores' => $supScores,
            'divScores' => $divScores,
            'statusMap' => $statusMap,
            'supHasScoreMap' => $supHasScoreMap,
            'divHasScoreMap' => $divHasScoreMap,
        ]);
    }

    public function show(Request $request, Employee $employee, AssessmentScoreCalculator $calculator)
    {
        $myCode = $this->currentUserCode();
        if (!$myCode) abort(403);

        $role = $this->resolveRoleFor($employee, $myCode);
        if (!$role) abort(403);

        $with = [];
        if (method_exists(Employee::class, 'appUser')) $with[] = 'appUser';
        if (method_exists(Employee::class, 'user')) $with[] = 'user';
        if (!empty($with)) $employee->loadMissing($with);

        $cycle = $this->activeCycleOrLatest();
        $cycleId = $cycle?->id;
        $hideEvaluateActionButtons = false;

        if ($cycle && Schema::hasColumn('cycles', 'is_read_mode')) {
            $hideEvaluateActionButtons = (bool)($cycle->is_read_mode ?? false);
        }

        $ex = null;
        if ($cycleId && Schema::hasTable('export_employees')) {
            $ex = ExportEmployee::query()
                ->where('cycle_id', (int)$cycleId)
                ->where('employee_code', (string)$employee->employee_code)
                ->first();
        }

        $avatarUrl = $this->avatarUrlForEmployee($employee);

        if (!$ex) {
            return view('assessment.evaluate', [
                'employee' => $employee,
                'avatarUrl' => $avatarUrl,
                'assessmentRole' => $role,
                'viewerRole' => $role,
                'calc' => null,
                'summaryLines' => [],
                'ipItems' => [],
                'leaderScore' => null,
                'attitudeScore' => null,
                'cycleId' => $cycleId,
                'assessmentStatus' => null,
                'hideEvaluateActionButtons' => $hideEvaluateActionButtons,
            ]);
        }

        $statusCol = $this->pickFirstExistingColumn('export_employees', ['assessment_status', 'assess_status']);
        $statusVal = $statusCol ? ($ex->{$statusCol} ?? null) : null;

        $leaderScore = $this->readRoleScoreFromExport($ex, $role, 'leadership');
        $attitudeScore = $this->readRoleScoreFromExport($ex, $role, 'attitude');

        // ✅ ใส่ค่าเป็น virtual attribute เพื่อให้ view (modal) ใช้งานได้ตรง ๆ ถ้าต้องการ
        if ($role === 'division') {
            $employee->setAttribute('division_score_leadership', $leaderScore);
            $employee->setAttribute('division_score_attitude', $attitudeScore);
        } else {
            $employee->setAttribute('score_leadership', $leaderScore);
            $employee->setAttribute('score_attitude', $attitudeScore);
        }

        $calc = $calculator->computeFromExport($ex, $role);
        if (!is_array($calc)) $calc = [];

        $calc['leaderScore'] = $leaderScore;
        $calc['attitudeScore'] = $attitudeScore;

        $calc = $this->recalcIpForView($calc, $leaderScore, $attitudeScore);

        return view('assessment.evaluate', [
            'employee' => $employee,
            'avatarUrl' => $avatarUrl,
            'assessmentRole' => $role,
            'viewerRole' => $role,
            'calc' => $calc,
            'summaryLines' => $calc['summaryLines'] ?? [],
            'ipItems' => $calc['ipItems'] ?? [],
            'leaderScore' => $leaderScore,
            'attitudeScore' => $attitudeScore,
            'cycleId' => $cycleId,
            'assessmentStatus' => $statusVal,
            'hideEvaluateActionButtons' => $hideEvaluateActionButtons,
        ]);
    }

    public function store(Request $request, Employee $employee, AssessmentScoreCalculator $calculator)
    {
        $myCode = $this->currentUserCode();
        if (!$myCode) abort(403);

        $role = $this->resolveRoleFor($employee, $myCode);
        if (!$role) abort(403);

        $cycle = $this->activeCycleOrLatest();
        $cycleId = $cycle?->id;
        if (!$cycleId) {
            throw ValidationException::withMessages(['cycle' => 'No active cycle.']);
        }

        if (!Schema::hasTable('export_employees')) {
            throw ValidationException::withMessages(['export' => 'export_employees table not found.']);
        }
        if (!Schema::hasColumn('export_employees', 'cycle_id') || !Schema::hasColumn('export_employees', 'employee_code')) {
            throw ValidationException::withMessages(['export' => 'export_employees missing cycle_id/employee_code.']);
        }

        $leaderKeys = [
            'score_leadership',
            'supervisor_score_leadership',
            'supervisor_score_leader',
            'sup_score_leadership',
            'sup_score_leader',
            'division_score_leadership',
            'division_score_leader',
            'div_score_leadership',
            'div_score_leader',
        ];

        $attKeys = [
            'score_attitude',
            'score_attritude',
            'supervisor_score_attitude',
            'supervisor_score_attritude',
            'sup_score_attitude',
            'sup_score_attritude',
            'division_score_attitude',
            'division_score_attritude',
            'div_score_attitude',
            'div_score_attritude',
        ];

        $leaderKey = $this->firstRequestKey($request, $leaderKeys);
        $attKey = $this->firstRequestKey($request, $attKeys);

        $leaderRaw = $leaderKey ? $request->input($leaderKey) : null;
        $attRaw = $attKey ? $request->input($attKey) : null;

        $request->merge([
            'score_leadership' => $this->normalizeNullableScore($leaderRaw),
            'score_attitude'   => $this->normalizeNullableScore($attRaw),
        ]);

        $data = $request->validate([
            'score_leadership' => ['nullable', 'numeric', 'min:0', 'max:10'],
            'score_attitude'   => ['nullable', 'numeric', 'min:0', 'max:10'],
        ]);

        $leaderScore = array_key_exists('score_leadership', $data) ? ($data['score_leadership'] === null ? null : (float)$data['score_leadership']) : null;
        $attitudeScore = array_key_exists('score_attitude', $data) ? ($data['score_attitude'] === null ? null : (float)$data['score_attitude']) : null;

        $ex = ExportEmployee::query()
            ->where('cycle_id', (int)$cycleId)
            ->where('employee_code', (string)$employee->employee_code)
            ->first();

        if (!$ex) {
            $seed = [
                'cycle_id' => (int)$cycleId,
                'employee_code' => (string)$employee->employee_code,
            ];

            $seedCols = [
                'full_name_th' => $employee->full_name_th ?? null,
                'full_name_en' => $employee->full_name_en ?? null,
                'employee_type' => $employee->employee_type ?? null,
                'position' => $employee->position ?? null,
                'department' => $employee->department ?? null,
                'dept_abbr_qms' => $employee->dept_abbr_qms ?? null,
                'dept_abbr_hr' => $employee->dept_abbr_hr ?? null,
                'sup_id' => $employee->sup_id ?? null,
                'sup_name' => $employee->sup_name ?? null,
                'div_mgr_id' => $employee->div_mgr_id ?? null,
                'div_mgr_name' => $employee->div_mgr_name ?? null,
                'dept_mgr_id' => $employee->dept_mgr_id ?? null,
                'dept_mgr_name' => $employee->dept_mgr_name ?? null,
                'plant_mgr_id' => $employee->plant_mgr_id ?? null,
                'plant_mgr_name' => $employee->plant_mgr_name ?? null,
                'position_level' => (isset($employee->position_level) && is_numeric($employee->position_level)) ? (int)$employee->position_level : null,
                'assessment_status' => $employee->assessment_status ?? null,
            ];

            foreach ($seedCols as $k => $v) {
                if (Schema::hasColumn('export_employees', $k)) $seed[$k] = $v;
            }

            $ex = ExportEmployee::create($seed);
        }

        $this->setScoreColsForRole($ex, $role, $leaderScore, $attitudeScore);

        $calc = $calculator->computeFromExport($ex, $role);
        $calculator->applyComputedToExport($ex, $calc, $role);

        $this->setScoreColsForRole($ex, $role, $leaderScore, $attitudeScore);

        $finalScore = null;
        if (is_array($calc) && array_key_exists('totalWithBonus', $calc) && is_numeric($calc['totalWithBonus'])) {
            $finalScore = (float)$calc['totalWithBonus'];
        }
        $this->setFinalScoreColsForRole($ex, $role, $finalScore);

        $ex->save();

        return redirect()
            ->route('assessment.employees.show', ['employee' => $employee->getRouteKey()])
            ->with('success', __('app.assess_saved_success'));
    }
}
