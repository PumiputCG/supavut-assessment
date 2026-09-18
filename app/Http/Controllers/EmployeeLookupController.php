<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Employee;
use App\Models\AppUser;
use App\Models\SelfEmployee;
use App\Models\EmployeeAssessment;

class EmployeeLookupController extends Controller
{
    public function lookup(Request $request)
    {
        $rawCode = (string) $request->input('employee_code', '');

        // เก็บแต่ตัวเลข (กันพิมพ์อักขระอื่น / เว้นวรรค)
        $code = preg_replace('/\D/', '', $rawCode);

        if ($code === '') {
            return response()->json([
                'found'   => false,
                'message' => __('app.emp_lookup_error_code_required'),
            ]);
        }

        // 0) พยายามหา "ตัวจริง" ก่อนเสมอ (เพื่อให้ได้ employee.id ไว้ดึง assessment)
        $realEmp = Employee::where('employee_code', $code)->first();
        if ($realEmp) {
            return $this->buildEmployeeResponse($realEmp, 'employee_code', $code);
        }

        // ฟังก์ชันช่วย: หา row จากคอลัมน์ manager โดย "พยายามเอาแถวที่ name ไม่ null ก่อน"
        $pickManagerRow = function (string $idField, string $nameField) use ($code) {
            return Employee::where($idField, $code)
                ->orderByRaw("$nameField IS NULL") // non-null มาก่อน
                ->orderBy('id')
                ->first();
        };

        // 1) sup_id = sup_name
        $row = $pickManagerRow('sup_id', 'sup_name');
        if ($row) {
            return $this->buildEmployeeResponse($row, 'sup_id', $code);
        }

        // 2) div_mgr_id = div_mgr_name
        $row = $pickManagerRow('div_mgr_id', 'div_mgr_name');
        if ($row) {
            return $this->buildEmployeeResponse($row, 'div_mgr_id', $code);
        }

        // 3) dept_mgr_id = dept_mgr_name
        $row = $pickManagerRow('dept_mgr_id', 'dept_mgr_name');
        if ($row) {
            return $this->buildEmployeeResponse($row, 'dept_mgr_id', $code);
        }

        // 4) plant_mgr_id = plant_mgr_name
        $row = $pickManagerRow('plant_mgr_id', 'plant_mgr_name');
        if ($row) {
            return $this->buildEmployeeResponse($row, 'plant_mgr_id', $code);
        }

        // ไม่พบในทุกคอลัมน์
        return response()->json([
            'found'   => false,
            'message' => __('app.emp_lookup_error_not_found'),
        ]);
    }

    /**
     * สร้าง response มาตรฐาน + ENRICH ให้เหมือน SummaryController (แต่เอา year/period ออก)
     *
     * @param  \App\Models\Employee  $row
     * @param  string                $matchField  employee_code|sup_id|div_mgr_id|dept_mgr_id|plant_mgr_id
     * @param  string                $inputCode   รหัสที่ user พิมพ์เข้ามา (หลัง strip ตัวอักษร)
     */
    protected function buildEmployeeResponse(Employee $row, string $matchField, string $inputCode)
    {
  
        $subjectCode = ($matchField === 'employee_code')
            ? (string) $row->employee_code
            : (string) $inputCode;


        $subjectEmp = ($matchField === 'employee_code')
            ? $row
            : Employee::where('employee_code', $subjectCode)->first(); // อาจ null ได้


        switch ($matchField) {
            case 'employee_code':
                $name = $row->full_name_th ?: ($row->full_name_en ?? '-');
                break;
            case 'sup_id':
                $name = $row->sup_name ?: '-';
                break;
            case 'div_mgr_id':
                $name = $row->div_mgr_name ?: '-';
                break;
            case 'dept_mgr_id':
                $name = $row->dept_mgr_name ?: '-';
                break;
            case 'plant_mgr_id':
                $name = $row->plant_mgr_name ?: '-';
                break;
            default:
                $name = $row->full_name_th ?: ($row->full_name_en ?? '-');
                break;
        }

        $positionLabel = $row->position;
        if (!$positionLabel) {
            switch ($matchField) {
                case 'sup_id':       $positionLabel = 'Supervisor'; break;
                case 'div_mgr_id':   $positionLabel = 'Division Manager'; break;
                case 'dept_mgr_id':  $positionLabel = 'Department Manager'; break;
                case 'plant_mgr_id': $positionLabel = 'Plant Manager'; break;
                default:             $positionLabel = 'Employee';
            }
        }

        $department = $row->dept_abbr_qms
            ?: $row->dept_abbr_hr
            ?: $row->department
            ?: '-';

        $profileUrl   = null;
        $selfQPercent = null;
        $selfQAll     = null;

        $supFinalScore    = null;
        $supGradeLetter   = null;
        $supGradeText     = null;
        $supIpPercent     = null;
        $supIpWeighted    = null;
        $supLeadership    = null;
        $supAttitude      = null;
        $supYear          = null; 
        $supPeriod        = null; 
        $supEvaluatorCode = null;

        $u = AppUser::where('username', $subjectCode)->first(['profile_picture', 'username']);
        if ($u && $u->profile_picture) {
            $profileUrl = asset('storage/' . ltrim($u->profile_picture, '/'));
        }


        $s = SelfEmployee::where('employee_code', $subjectCode)
            ->orderByDesc('id')
            ->first(['q_percent', 'q_all']);

        if ($s) {
            $selfQPercent = $s->q_percent;
            $selfQAll     = $s->q_all;
        }

        if ($subjectEmp && $subjectEmp->id) {
            $a = EmployeeAssessment::query()
                ->where('employee_id', $subjectEmp->id)
                ->where('evaluator_role', EmployeeAssessment::ROLE_SUPERVISOR)
                ->orderByDesc('id')
                ->first([
                    'evaluator_id',
                    'final_score',
                    'grade_letter',
                    'grade_text',
                    'ip_percent',
                    'ip_weighted',
                    'score_leadership',
                    'score_attitude',
                    'created_at',
                ]);

            if ($a) {
                $supFinalScore  = $a->final_score;
                $supGradeLetter = $a->grade_letter;
                $supGradeText   = $a->grade_text;
                $supIpPercent   = $a->ip_percent;
                $supIpWeighted  = $a->ip_weighted;
                $supLeadership  = $a->score_leadership;
                $supAttitude    = $a->score_attitude;

                if (!empty($a->created_at)) {
                    try {
                        $supYear = (int) $a->created_at->format('Y');
                    } catch (\Throwable $e) {
                        $supYear = null;
                    }
                }

                if ($a->evaluator_id) {
                    $ev = AppUser::where('id', $a->evaluator_id)->first(['username']);
                    $supEvaluatorCode = $ev?->username;
                }
            }
        }

      
        $employeePayload = [
            'employee_code' => $subjectCode,
            'full_name_th'  => $subjectEmp?->full_name_th ?? null,
            'full_name_en'  => $subjectEmp?->full_name_en ?? null,
            'employee_type' => $subjectEmp?->employee_type ?? null,
            'position'      => $subjectEmp?->position ?? $row->position,
            'department'    => $subjectEmp?->department ?? $row->department,
            'dept_abbr_qms' => $subjectEmp?->dept_abbr_qms ?? $row->dept_abbr_qms,
            'dept_abbr_hr'  => $subjectEmp?->dept_abbr_hr ?? $row->dept_abbr_hr,

            'sup_id'        => $subjectEmp?->sup_id ?? $row->sup_id,
            'sup_name'      => $subjectEmp?->sup_name ?? $row->sup_name,

            'div_mgr_id'    => $subjectEmp?->div_mgr_id ?? $row->div_mgr_id,
            'div_mgr_name'  => $subjectEmp?->div_mgr_name ?? $row->div_mgr_name,

            'dept_mgr_id'   => $subjectEmp?->dept_mgr_id ?? $row->dept_mgr_id,
            'dept_mgr_name' => $subjectEmp?->dept_mgr_name ?? $row->dept_mgr_name,

            'plant_mgr_id'   => $subjectEmp?->plant_mgr_id ?? $row->plant_mgr_id,
            'plant_mgr_name' => $subjectEmp?->plant_mgr_name ?? $row->plant_mgr_name,

            '_profile_url'        => $profileUrl,
            '_self_q_percent'     => $selfQPercent,
            '_self_q_all'         => $selfQAll,

            '_sup_final_score'    => $supFinalScore,
            '_sup_grade_letter'   => $supGradeLetter,
            '_sup_grade_text'     => $supGradeText,
            '_sup_ip_percent'     => $supIpPercent,
            '_sup_ip_weighted'    => $supIpWeighted,
            '_sup_leadership'     => $supLeadership,
            '_sup_attitude'       => $supAttitude,
            '_sup_year'           => $supYear,  
            '_sup_period'         => $supPeriod, 
            '_sup_evaluator_code' => $supEvaluatorCode,
        ];

        return response()->json([
            'found'       => true,
            'match_type'  => $matchField,
            'match_code'  => $inputCode,

            'name'        => $name,
            'position'    => $positionLabel,
            'department'  => $department,

            // เผื่อโค้ดหน้าเว็บคุณอ่านจาก root ก็ให้มาครบเหมือนกัน
            '_profile_url'        => $profileUrl,
            '_self_q_percent'     => $selfQPercent,
            '_self_q_all'         => $selfQAll,

            '_sup_final_score'    => $supFinalScore,
            '_sup_grade_letter'   => $supGradeLetter,
            '_sup_grade_text'     => $supGradeText,
            '_sup_ip_percent'     => $supIpPercent,
            '_sup_ip_weighted'    => $supIpWeighted,
            '_sup_leadership'     => $supLeadership,
            '_sup_attitude'       => $supAttitude,
            '_sup_year'           => $supYear,   
            '_sup_period'         => $supPeriod,  
            '_sup_evaluator_code' => $supEvaluatorCode,

            'employee'    => $employeePayload,
        ]);
    }
}
