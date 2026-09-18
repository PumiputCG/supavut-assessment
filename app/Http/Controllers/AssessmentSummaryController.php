<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

use App\Models\Employee;
use App\Models\AppUser;
use App\Models\Cycle;

class AssessmentSummaryController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        if (!$user) abort(403, 'กรุณาเข้าสู่ระบบ');

        if (method_exists($user, 'canViewEmployeesEvaluation') && !$user->canViewEmployeesEvaluation()) {
            abort(403, 'คุณไม่มีสิทธิ์เข้าหน้านี้');
        }

        $meCode = $user->username ?? null;
        if (!$meCode) abort(403, 'ไม่พบรหัสพนักงาน (username)');

        $cycle = null;
        if (Schema::hasTable('cycles')) {
            $q = Cycle::query()->orderByDesc('id');

            if (Schema::hasColumn('cycles', 'is_active')) {
                $cycle = (clone $q)->where('is_active', true)->first();
            }
            if (!$cycle && Schema::hasColumn('cycles', 'status')) {
                $openStatus = (defined(Cycle::class . '::STATUS_OPEN') ? Cycle::STATUS_OPEN : 'open');
                $cycle = (clone $q)->where('status', $openStatus)->first();
            }
        }
        $cycleId = $cycle ? (int)$cycle->id : null;

        // ====== สิทธิ์ตามโครงสร้างจริง ======
        $canPlant = Employee::where('plant_mgr_id', $meCode)->exists();
        $canDept  = Employee::where('dept_mgr_id',  $meCode)->exists();

        if (!$canDept && !$canPlant) {
            abort(403, 'ไม่พบสายงานสำหรับ Dept/Plant ของคุณ');
        }

        // ====== scope ======
        $scopeReq = $request->query('scope');
        if ($scopeReq !== 'plant' && $scopeReq !== 'dept') {
            $scope = $canPlant ? 'plant' : 'dept';
        } else {
            $scope = $scopeReq;
        }

        if ($scope === 'plant' && !$canPlant && $canDept) $scope = 'dept';
        if ($scope === 'dept'  && !$canDept  && $canPlant) $scope = 'plant';

        $meEmp = Employee::where('employee_code', $meCode)->first();

        $empName = function ($e) {
            return data_get($e, 'full_name_th')
                ?? data_get($e, 'full_name_en')
                ?? data_get($e, 'employee_code')
                ?? '-';
        };

        $plantInfo = ['code' => '-', 'name' => '-'];
        $deptInfo  = ['code' => '-', 'name' => '-'];

        $counts = [
            'all' => 0,
            'dept' => 0,
            'division' => 0,
            'supervisor' => 0,
            'employee' => 0,
        ];

        $deptBlocks = []; 
        $divisions  = []; 

        $listEmployees = collect();
        $supCodes = collect();

        $pushEmp = function ($emp) use (&$listEmployees) {
            if ($emp instanceof Employee) {
                $listEmployees->push($emp);
            }
        };

        $buildEmployeesUnderSup = function ($line, $supId) {
            return $line
                ->filter(function ($e) use ($supId) {
                    $code = data_get($e, 'employee_code');
                    if (!$code) return false;
                    if ((string)$code === (string)$supId) return false;
                    return true;
                })
                ->values();
        };

        if ($scope === 'plant') {
            $plantLine = Employee::where('plant_mgr_id', $meCode)->get();

            $plantInfo = [
                'code' => $meCode,
                'name' => $meEmp ? $empName($meEmp) : ($user->email ?? $meCode),
            ];

            $deptMgrIds = $plantLine->pluck('dept_mgr_id')->filter()->unique()->values();

            $deptMgrMap = Employee::whereIn('employee_code', $deptMgrIds)
                ->get()
                ->keyBy('employee_code');

            $divIds = $plantLine->pluck('div_mgr_id')->filter()->unique()->values();
            $supIds = $plantLine->pluck('sup_id')->filter()->unique()->values();

            $managerCodes = collect()
                ->merge([$meCode])
                ->merge($deptMgrIds)
                ->merge($divIds)
                ->merge($supIds)
                ->filter()
                ->unique()
                ->values()
                ->all();

            $employeesOnlyForCount = $plantLine->filter(function ($e) use ($managerCodes) {
                $code = data_get($e, 'employee_code');
                if (!$code) return false;
                return !in_array($code, $managerCodes, true);
            });

            $counts['all'] = $plantLine->count();
            $counts['dept'] = $deptMgrIds->count();
            $counts['division'] = $divIds->count();
            $counts['supervisor'] = $supIds->count();
            $counts['employee'] = $employeesOnlyForCount->count();

            foreach ($deptMgrIds as $deptId) {
                $deptMgrEmp = $deptMgrMap->get($deptId);

                $deptName = $deptMgrEmp
                    ? $empName($deptMgrEmp)
                    : (data_get($plantLine->firstWhere('dept_mgr_id', $deptId), 'dept_mgr_name') ?? '-');

                $deptLine = $plantLine->where('dept_mgr_id', $deptId)->values();
                $deptDivIds = $deptLine->pluck('div_mgr_id')->filter()->unique()->values();

                $deptDivisions = [];
                foreach ($deptDivIds as $divId) {
                    $divName = data_get($deptLine->firstWhere('div_mgr_id', $divId), 'div_mgr_name') ?? '-';
                    $divLine = $deptLine->where('div_mgr_id', $divId)->values();

                    $divSupIds = $divLine->pluck('sup_id')->filter()->unique()->values();
                    $supBlocks = [];

                    foreach ($divSupIds as $supId) {
                        $supName = data_get($divLine->firstWhere('sup_id', $supId), 'sup_name') ?? '-';

                        $raw = $divLine->where('sup_id', $supId)->values();
                        $emps = $buildEmployeesUnderSup($raw, $supId);

                        $supBlocks[] = [
                            'sup_code' => $supId,
                            'sup_name' => $supName,
                            'employees' => $emps,
                        ];

                        $supCodes->push($supId);
                        foreach ($emps as $emp) $pushEmp($emp);
                    }

                    $deptDivisions[] = [
                        'div_code' => $divId,
                        'div_name' => $divName,
                        'supBlocks' => $supBlocks,
                    ];
                }

                $deptBlocks[] = [
                    'dept_code' => $deptId,
                    'dept_name' => $deptName,
                    'deptManager' => $deptMgrEmp,
                    'divisions' => $deptDivisions,
                ];
            }
        }

        if ($scope === 'dept') {
            $deptInfo = [
                'code' => $meCode,
                'name' => $meEmp ? $empName($meEmp) : ($user->email ?? $meCode),
            ];

            $plantMgrId = data_get($meEmp, 'plant_mgr_id')
                ?? Employee::where('dept_mgr_id', $meCode)->value('plant_mgr_id');

            if ($plantMgrId) {
                $plantMgrEmp = Employee::where('employee_code', $plantMgrId)->first();
                $plantInfo = [
                    'code' => $plantMgrId,
                    'name' => $plantMgrEmp
                        ? $empName($plantMgrEmp)
                        : (Employee::where('dept_mgr_id', $meCode)->value('plant_mgr_name') ?? '-'),
                ];
            }

            $deptLine = Employee::where('dept_mgr_id', $meCode)->get();

            $divIds = $deptLine->pluck('div_mgr_id')->filter()->unique()->values();
            $supIds = $deptLine->pluck('sup_id')->filter()->unique()->values();

            $managerCodes = collect()
                ->merge([$plantMgrId, $meCode])
                ->merge($divIds)
                ->merge($supIds)
                ->filter()
                ->unique()
                ->values()
                ->all();

            $employeesOnlyForCount = $deptLine->filter(function ($e) use ($managerCodes) {
                $code = data_get($e, 'employee_code');
                if (!$code) return false;
                return !in_array($code, $managerCodes, true);
            });

            $counts['all'] = $deptLine->count();
            $counts['dept'] = 1;
            $counts['division'] = $divIds->count();
            $counts['supervisor'] = $supIds->count();
            $counts['employee'] = $employeesOnlyForCount->count();

            foreach ($divIds as $divId) {
                $divName = data_get($deptLine->firstWhere('div_mgr_id', $divId), 'div_mgr_name') ?? '-';
                $divLine = $deptLine->where('div_mgr_id', $divId)->values();

                $divSupIds = $divLine->pluck('sup_id')->filter()->unique()->values();
                $supBlocks = [];

                foreach ($divSupIds as $supId) {
                    $supName = data_get($divLine->firstWhere('sup_id', $supId), 'sup_name') ?? '-';

                    $raw = $divLine->where('sup_id', $supId)->values();
                    $emps = $buildEmployeesUnderSup($raw, $supId);

                    $supBlocks[] = [
                        'sup_code' => $supId,
                        'sup_name' => $supName,
                        'employees' => $emps,
                    ];

                    $supCodes->push($supId);
                    foreach ($emps as $emp) $pushEmp($emp);
                }

                $divisions[] = [
                    'div_code' => $divId,
                    'div_name' => $divName,
                    'supBlocks' => $supBlocks,
                ];
            }
        }

        $listEmployees = $listEmployees->filter()->unique('employee_code')->values();
        $empCodes = $listEmployees->pluck('employee_code')->filter()->unique()->values();
        $supCodes = $supCodes->filter()->unique()->values();

        $allCodes = collect()->merge($empCodes)->merge($supCodes)->filter()->unique()->values();

        // 1) profile picture (รวม supervisor ด้วย)
        $usersMap = AppUser::whereIn('username', $allCodes)
            ->get(['id', 'username', 'profile_picture'])
            ->keyBy('username');

        // 2) export table (active)
        $exportTable = null;
        if (Schema::hasTable('export_employee')) $exportTable = 'export_employee';
        elseif (Schema::hasTable('export_employees')) $exportTable = 'export_employees';

        $expMap = [];
        $selfCol = null;
        $supCol  = null;

        if ($cycleId && $exportTable) {
            if (Schema::hasColumn($exportTable, 'q_percent')) $selfCol = 'q_percent';
            if (Schema::hasColumn($exportTable, 'supervisor_final_score')) $supCol = 'supervisor_final_score';
            if (!$selfCol) {
                foreach (['self_q_percent','self_percent','self_score'] as $c) {
                    if (Schema::hasColumn($exportTable, $c)) { $selfCol = $c; break; }
                }
            }
            if (!$supCol) {
                foreach (['sup_final_score','supervisor_score','sup_score'] as $c) {
                    if (Schema::hasColumn($exportTable, $c)) { $supCol = $c; break; }
                }
            }

            if (
                Schema::hasColumn($exportTable, 'employee_code')
                && Schema::hasColumn($exportTable, 'cycle_id')
            ) {
                $select = ['employee_code'];
                if ($selfCol) $select[] = $selfCol;
                if ($supCol)  $select[] = $supCol;

                $expRows = DB::table($exportTable)
                    ->where('cycle_id', $cycleId)
                    ->whereIn('employee_code', $allCodes)
                    ->get($select);

                foreach ($expRows as $r) {
                    $c = trim((string)($r->employee_code ?? ''));
                    if ($c === '') continue;
                    $expMap[$c] = $r;
                }
            }
        }

        $getExp = function (string $code) use (&$expMap) {
            return $expMap[$code] ?? null;
        };

        foreach ($listEmployees as $emp) {
            $code = trim((string)($emp->employee_code ?? ''));
            if ($code === '') continue;

       
            $u = $usersMap->get($code);
            $pic = data_get($u, 'profile_picture');
            $emp->setAttribute('_profile_url', $pic ? asset('storage/' . ltrim($pic, '/')) : null);

          
            $ex = $getExp($code);
            $emp->setAttribute('_self_q_percent', ($ex && $selfCol) ? ($ex->{$selfCol} ?? null) : null);
            $emp->setAttribute('_sup_final_score', ($ex && $supCol) ? ($ex->{$supCol} ?? null) : null);
        }
        $applyToSupBlocks = function (&$supBlocks) use ($usersMap, $getExp, $selfCol, $supCol) {
            foreach ($supBlocks as &$sb) {
                $scode = trim((string)(data_get($sb, 'sup_code') ?? ''));
                if ($scode === '') continue;

                $u = $usersMap->get($scode);
                $pic = data_get($u, 'profile_picture');
                $sb['_profile_url'] = $pic ? asset('storage/' . ltrim($pic, '/')) : null;

                $ex = $getExp($scode);
                $sb['_self_q_percent'] = ($ex && $selfCol) ? ($ex->{$selfCol} ?? null) : null;
                $sb['_sup_final_score'] = ($ex && $supCol) ? ($ex->{$supCol} ?? null) : null;
            }
            unset($sb);
        };

        if ($scope === 'plant') {
            foreach ($deptBlocks as &$dept) {
                $divs = data_get($dept, 'divisions') ?? [];
                foreach ($divs as &$div) {
                    $sb = data_get($div, 'supBlocks') ?? [];
                    $applyToSupBlocks($sb);
                    $div['supBlocks'] = $sb;
                }
                unset($div);
                $dept['divisions'] = $divs;
            }
            unset($dept);
        } else {
            foreach ($divisions as &$div) {
                $sb = data_get($div, 'supBlocks') ?? [];
                $applyToSupBlocks($sb);
                $div['supBlocks'] = $sb;
            }
            unset($div);
        }

        return view('assessment.overview', [
            'scope' => $scope,
            'canPlant' => $canPlant,
            'canDept' => $canDept,

            'plantInfo' => $plantInfo,
            'deptInfo'  => $deptInfo,

            'counts' => $counts,

         
            'cycle'   => $cycle,
            'cycleId' => $cycleId,

        
            'deptBlocks' => $deptBlocks,

            'divisions' => $divisions,
        ]);
    }
}
