<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Cycle;
use App\Models\Employee;
use App\Models\AppUser;

class ExportEmployeeHistory extends Model
{
    use HasFactory;

    protected $table = 'export_employee_history';

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

        // Attendance
        'attendance_total',
        'attendance_sick',
        'attendance_personal',
        'attendance_maternity',
        'attendance_ordain',
        'attendance_late',
        'attendance_absent',
        'attendance_warning',
        'attendance_suspension',

        // Scores
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

        // Supervisor
        'supervisor_score_leadership',
        'supervisor_score_attitude',
        'supervisor_final_score',
        'supervisor_grade',
        'supervisor_grade_text',

        // Division
        'division_score_leadership',
        'division_score_attitude',
        'division_final_score',
        'division_grade',
        'division_grade_text',

        // Self
        'q_percent',
    ];

    protected $casts = [
        'cycle_id'       => 'integer',
        'position_level' => 'integer',

        // Attendance
        'attendance_total'      => 'float',
        'attendance_sick'       => 'float',
        'attendance_personal'   => 'float',
        'attendance_maternity'  => 'float',
        'attendance_ordain'     => 'float',
        'attendance_late'       => 'float',
        'attendance_absent'     => 'float',
        'attendance_warning'    => 'float',
        'attendance_suspension' => 'float',

        // Scores
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

        // Supervisor / Division
        'supervisor_score_leadership' => 'float',
        'supervisor_score_attitude'   => 'float',
        'supervisor_final_score'      => 'float',
        'division_score_leadership'   => 'float',
        'division_score_attitude'     => 'float',
        'division_final_score'        => 'float',

        // Self
        'q_percent' => 'float',
    ];

    public function cycle() { return $this->belongsTo(Cycle::class, 'cycle_id'); }
    public function employee() { return $this->belongsTo(Employee::class, 'employee_code', 'employee_code'); }
    public function user() { return $this->belongsTo(AppUser::class, 'employee_code', 'username'); }
}
