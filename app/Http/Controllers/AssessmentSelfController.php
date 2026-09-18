<?php

namespace App\Http\Controllers;

use App\Models\Cycle;
use App\Models\Employee;
use App\Models\SelfEmployee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use App\Services\ExportEmployeeBuilder;

class AssessmentSelfController extends Controller
{
    private function activeCycleOrFail(): Cycle
    {
        $cycle = Cycle::active(); // ต้องเป็น is_active=1 + status=open
        abort_unless($cycle, 403, 'ไม่มีรอบที่เปิดอยู่ (ACTIVE)');
        return $cycle;
    }

    public function index()
    {
        $user = Auth::user();
        abort_unless($user, 403, 'กรุณาเข้าสู่ระบบ');

        $employeeCode = $user->username ?? null;
        abort_unless($employeeCode, 403, 'ไม่พบรหัสพนักงานของผู้ใช้');

        $isTopExecAccount = in_array($employeeCode, ['60003', '60004'], true);
        if ($user->role === 'admin' || $isTopExecAccount) {
            abort(403, 'คุณไม่มีสิทธิ์เข้าหน้าประเมินตัวเอง');
        }

        $cycle = $this->activeCycleOrFail();

        $employee = Employee::where('employee_code', $employeeCode)->first();
        abort_unless($employee, 404, 'ไม่พบข้อมูลพนักงานในระบบประเมิน (employees)');

        $self = SelfEmployee::where('cycle_id', (int)$cycle->id)
            ->where('employee_code', $employee->employee_code)
            ->first();

        $questions = $this->getQuestionsForEmployee($employee);

        return view('assessment.self', [
            'user'      => $user,
            'employee'  => $employee,
            'self'      => $self,
            'questions' => $questions,
            'readonly'  => false,
            'cycle'     => $cycle,
        ]);
    }

    public function store(Request $request, ExportEmployeeBuilder $exportBuilder)
    {
        $user = Auth::user();
        abort_unless($user, 403, 'กรุณาเข้าสู่ระบบ');

        $employeeCode = $user->username ?? null;
        abort_unless($employeeCode, 403, 'ไม่พบรหัสพนักงานของผู้ใช้');

        $isTopExecAccount = in_array($employeeCode, ['60003', '60004'], true);
        if ($user->role === 'admin' || $isTopExecAccount) {
            abort(403, 'คุณไม่มีสิทธิ์ส่งแบบประเมินตัวเอง');
        }

        $cycle = $this->activeCycleOrFail();
        $cycleId = (int)$cycle->id;

        $employee = Employee::where('employee_code', $employeeCode)->first();
        abort_unless($employee, 404, 'ไม่พบข้อมูลพนักงานในระบบประเมิน (employees)');

        $questions = $this->getQuestionsForEmployee($employee);

        $rules = [];
        foreach ($questions as $no => $meta) {
            $rules['q'.$no] = ['required', 'in:0,1,2,3,4,na'];
        }
        $validated = $request->validate($rules);

        $sum              = 0;
        $scoreQuestionCnt = 0;
        $questionValues   = [];

        foreach ($questions as $no => $meta) {
            $field = 'q'.$no;
            $raw   = $validated[$field] ?? null;

            if ($raw === 'na') {
                $questionValues[$field] = null;
                continue;
            }

            $score = (int)$raw;
            $questionValues[$field] = $score;

            if ($score >= 0 && $score <= 4) {
                $sum += $score;
                $scoreQuestionCnt++;
            }
        }

        $max      = $scoreQuestionCnt * 4;
        $qAll     = $max > 0 ? "{$sum}/{$max}" : null;
        $qPercent = $max > 0 ? round(($sum / $max) * 100, 2) : null;

        $dataBase = [
            'cycle_id'       => $cycleId,
            'employee_code'  => $employee->employee_code,
            'position'       => $employee->position,
            'position_level' => (int)$this->resolvePositionLevel($employee),
            'q_all'          => $qAll,
            'q_percent'      => $qPercent,
        ];

        $data = array_merge($dataBase, $questionValues);

        DB::transaction(function () use ($employee, $cycleId, $data) {
            SelfEmployee::updateOrCreate(
                ['cycle_id' => (int)$cycleId, 'employee_code' => $employee->employee_code],
                $data
            );
        });

        try {
            $exportBuilder->buildForEmployeeInCycle($employee, $cycleId);
        } catch (\Throwable $e) {

        }

        return redirect()
            ->route('assessment.self')
            ->with('success', 'บันทึกแบบประเมินตนเองเรียบร้อยแล้ว');
    }

    public function showEmployee(string $code)
    {
        $user = Auth::user();
        abort_unless($user, 403, 'กรุณาเข้าสู่ระบบ');

        $cycle = $this->activeCycleOrFail();

        $employee  = Employee::where('employee_code', $code)->firstOrFail();

        $self = SelfEmployee::where('cycle_id', (int)$cycle->id)
            ->where('employee_code', $employee->employee_code)
            ->first();

        $questions = $this->getQuestionsForEmployee($employee);

        if ($user->username !== $employee->employee_code && $user->role !== 'admin') {
            abort(403, 'คุณไม่มีสิทธิ์ดูแบบประเมินตัวเองของพนักงานคนนี้');
        }

        return view('assessment.self', [
            'user'      => $user,
            'employee'  => $employee,
            'self'      => $self,
            'questions' => $questions,
            'readonly'  => true,
            'cycle'     => $cycle,
        ]);
    }

    // ===== Helpers เดิม =====
    protected function resolvePositionLevel(Employee $employee): int
    {
        if (! empty($employee->position_level)) {
            return (int) $employee->position_level;
        }

        $position = mb_strtolower(trim((string) $employee->position));
        $map = [
            1 => ['cooking','driver','maid','operator','senior operator','support mat','tp man'],
            2 => ['foreman','leader','senior staff','senior technician','staff','technician'],
            3 => ['engineer','senior engineer','supervisor'],
            4 => ['assist manager','assistant manager','manager'],
            5 => ['deputy general manager','general manager'],
        ];

        foreach ($map as $level => $names) {
            if (in_array($position, $names, true)) {
                return (int) $level;
            }
        }

        return 0;
    }

    protected function getQuestionsForEmployee(Employee $employee): array
    {
        $allQuestions = config('self_questions') ?? [];
        $level        = $this->resolvePositionLevel($employee);

        return collect($allQuestions)
            ->filter(function ($meta) use ($level) {
                if (empty($meta['for_levels']) || !is_array($meta['for_levels'])) {
                    return true;
                }
                if ($level <= 0) {
                    return false;
                }
                $levels = array_map('intval', $meta['for_levels']);
                return in_array($level, $levels, true);
            })
            ->all();
    }
}
