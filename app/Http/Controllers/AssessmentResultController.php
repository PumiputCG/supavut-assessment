<?php

namespace App\Http\Controllers;

use App\Models\AppUser;
use App\Models\Cycle;
use App\Models\Employee;
use App\Models\ExportEmployee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;

class AssessmentResultController extends Controller
{
    protected const ROLE_SUPERVISOR = 'supervisor';
    protected const ROLE_DIVISION   = 'division';

    protected function activeCycleOrAbort(): Cycle
    {
        $q = Cycle::query()->orderByDesc('id');

        if (Schema::hasColumn('cycles', 'is_active')) {
            $cycle = Cycle::query()->where('is_active', true)->orderByDesc('id')->first();
            if ($cycle) return $cycle;
        }

        if (Schema::hasColumn('cycles', 'status') && defined(Cycle::class . '::STATUS_OPEN')) {
            $cycle = Cycle::query()->where('status', Cycle::STATUS_OPEN)->orderByDesc('id')->first();
            if ($cycle) return $cycle;
        }

        $cycle = $q->first();
        if (!$cycle) {
            abort(403, 'ยังไม่มีรอบ (Cycle) ในระบบ กรุณาให้ Admin สร้างรอบก่อน');
        }
        return $cycle;
    }

    protected function normalizeEmployeeCode($code): string
    {
        $raw = trim((string)($code ?? ''));
        if ($raw === '') return '';
        $digits = preg_replace('/\D+/', '', $raw);
        return $digits !== '' ? $digits : $raw;
    }

    protected function resolveRole(Employee $employee, AppUser $user): ?string
    {
        $u = (string)($user->username ?? '');

        if (!empty($employee->sup_id) && (string)$employee->sup_id === $u) return self::ROLE_SUPERVISOR;
        if (!empty($employee->div_mgr_id) && (string)$employee->div_mgr_id === $u) return self::ROLE_DIVISION;

        if (
            !empty($employee->sup_id) && !empty($employee->div_mgr_id) &&
            (string)$employee->sup_id === $u && (string)$employee->div_mgr_id === $u
        ) {
            return self::ROLE_SUPERVISOR;
        }

        return null;
    }

    public function store(Request $request, Employee $employee)
    {
        /** @var AppUser|null $user */
        $user = Auth::user();
        if (!$user) abort(401);

        $cycle = $this->activeCycleOrAbort();
        $cycleId = (int)$cycle->id;

        $role = $this->resolveRole($employee, $user);
        if ($role === null) abort(403, 'คุณไม่มีสิทธิ์บันทึกผลประเมินของพนักงานคนนี้');

        $data = $request->validate([
            'total_score'      => ['nullable', 'numeric', 'min:0', 'max:105'],
            'final_score'      => ['nullable', 'numeric', 'min:0', 'max:105'],

            'grade_letter'     => ['required', 'string', 'max:2'],
            'grade_text'       => ['nullable', 'string', 'max:255'],

            'period'           => ['nullable', 'string', 'max:20'],

            'ip_sum'           => ['nullable', 'numeric'],
            'ip_percent'       => ['nullable', 'numeric'],
            'ip_weighted'      => ['nullable', 'numeric'],

            'score_leadership' => ['nullable', 'numeric', 'min:0', 'max:10'],
            'score_attitude'   => ['nullable', 'numeric', 'min:0', 'max:10'],
        ]);

        $incomingScore = $data['total_score'] ?? $data['final_score'] ?? null;
        if ($incomingScore === null) {
            return back()->withErrors(['total_score' => 'ไม่พบคะแนนรวม (total_score)'])->withInput();
        }

        $finalScore = (float)$incomingScore;
        if ($finalScore < 0) $finalScore = 0;
        if ($finalScore > 105) $finalScore = 105;

        $empCode = $this->normalizeEmployeeCode($employee->employee_code ?? '');
        if ($empCode === '') abort(422, 'ไม่พบ employee_code');

        $leader = array_key_exists('score_leadership', $data) ? ($data['score_leadership'] !== null ? (float)$data['score_leadership'] : null) : null;
        $att    = array_key_exists('score_attitude', $data) ? ($data['score_attitude'] !== null ? (float)$data['score_attitude'] : null) : null;

        $hasExportCycle = Schema::hasTable('export_employees') && Schema::hasColumn('export_employees', 'cycle_id');

        $key = ['employee_code' => $empCode];
        if ($hasExportCycle) $key['cycle_id'] = $cycleId;

        $export = ExportEmployee::firstOrNew($key);
        if ($hasExportCycle) $export->cycle_id = $cycleId;

        $up = [];

        if ($role === self::ROLE_SUPERVISOR) {
            if (Schema::hasColumn('export_employees', 'supervisor_score_leadership')) $up['supervisor_score_leadership'] = $leader;
            if (Schema::hasColumn('export_employees', 'supervisor_score_attitude'))   $up['supervisor_score_attitude']   = $att;

            if (Schema::hasColumn('export_employees', 'supervisor_final_score'))      $up['supervisor_final_score']      = $finalScore;
            if (Schema::hasColumn('export_employees', 'supervisor_grade'))            $up['supervisor_grade']            = $data['grade_letter'];
            if (Schema::hasColumn('export_employees', 'supervisor_grade_text'))       $up['supervisor_grade_text']       = $data['grade_text'] ?? null;

            if (Schema::hasColumn('export_employees', 'score_leadership')) $up['score_leadership'] = $leader;
            if (Schema::hasColumn('export_employees', 'score_attitude'))   $up['score_attitude']   = $att;
        } else {
            if (Schema::hasColumn('export_employees', 'division_score_leadership')) $up['division_score_leadership'] = $leader;
            if (Schema::hasColumn('export_employees', 'division_score_attitude'))   $up['division_score_attitude']   = $att;

            if (Schema::hasColumn('export_employees', 'division_final_score'))      $up['division_final_score']      = $finalScore;
            if (Schema::hasColumn('export_employees', 'division_grade'))            $up['division_grade']            = $data['grade_letter'];
            if (Schema::hasColumn('export_employees', 'division_grade_text'))       $up['division_grade_text']       = $data['grade_text'] ?? null;
        }

        if (Schema::hasColumn('export_employees', 'ip_sum'))      $up['ip_sum']      = $data['ip_sum'] ?? null;
        if (Schema::hasColumn('export_employees', 'ip_percent'))  $up['ip_percent']  = $data['ip_percent'] ?? null;
        if (Schema::hasColumn('export_employees', 'ip_weighted')) $up['ip_weighted'] = $data['ip_weighted'] ?? null;

        if (Schema::hasColumn('export_employees', 'period')) $up['period'] = $data['period'] ?? null;

        if (!empty($up)) {
            $export->fill($up);
            $export->employee_code = $empCode;
            $export->save();
        }

        if ($role === self::ROLE_SUPERVISOR) {
            $empUp = [];
            if (Schema::hasColumn('employees', 'score_leadership')) $empUp['score_leadership'] = $leader;
            if (Schema::hasColumn('employees', 'score_attitude'))   $empUp['score_attitude']   = $att;
            if (Schema::hasColumn('employees', 'supervisor_score_leadership')) $empUp['supervisor_score_leadership'] = $leader;
            if (Schema::hasColumn('employees', 'supervisor_score_attitude'))   $empUp['supervisor_score_attitude']   = $att;
            if (Schema::hasColumn('employees', 'assessment_status')) $empUp['assessment_status'] = '1/1';
            if (!empty($empUp)) {
                $employee->fill($empUp);
                $employee->save();
            }
        } else {
            $empUp = [];
            if (Schema::hasColumn('employees', 'division_score_leadership')) $empUp['division_score_leadership'] = $leader;
            if (Schema::hasColumn('employees', 'division_score_attitude'))   $empUp['division_score_attitude']   = $att;
            if (Schema::hasColumn('employees', 'assessment_status')) $empUp['assessment_status'] = '2/2';
            if (!empty($empUp)) {
                $employee->fill($empUp);
                $employee->save();
            }
        }

        Log::info('ASSESSMENT_SAVE_TOTAL_OK_EXPORT_ONLY', [
            'cycle_id' => $cycleId,
            'employee_id' => $employee->id,
            'employee_code' => $empCode,
            'role' => $role,
            'final_score' => $finalScore,
        ]);

        $msg = (__('app.assess_saved_success') !== 'app.assess_saved_success')
            ? __('app.assess_saved_success')
            : 'บันทึกผลการประเมินเรียบร้อยแล้ว';

        return back()->with('success', $msg);
    }
}
