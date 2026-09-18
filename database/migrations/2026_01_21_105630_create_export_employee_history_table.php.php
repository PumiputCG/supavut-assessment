<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('export_employee_history', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('cycle_id')->index();
            $table->foreign('cycle_id')->references('id')->on('cycles')->cascadeOnDelete();

            $table->string('employee_code', 30)->index();
            $table->string('full_name_th', 255)->nullable();
            $table->string('full_name_en', 255)->nullable();
            $table->string('employee_type', 100)->nullable();
            $table->string('position', 255)->nullable();
            $table->string('department', 255)->nullable();
            $table->string('dept_abbr_qms', 50)->nullable();
            $table->string('dept_abbr_hr', 50)->nullable();

            $table->string('sup_id', 30)->nullable();
            $table->string('sup_name', 255)->nullable();

            $table->string('div_mgr_id', 30)->nullable();
            $table->string('div_mgr_name', 255)->nullable();

            $table->string('dept_mgr_id', 30)->nullable();
            $table->string('dept_mgr_name', 255)->nullable();

            $table->string('plant_mgr_id', 30)->nullable();
            $table->string('plant_mgr_name', 255)->nullable();

            $table->unsignedTinyInteger('position_level')->nullable();

            $table->decimal('attendance_total', 10, 2)->nullable();
            $table->decimal('attendance_sick', 10, 2)->nullable()->default(0);
            $table->decimal('attendance_personal', 10, 2)->nullable()->default(0);
            $table->decimal('attendance_maternity', 10, 2)->nullable()->default(0);
            $table->decimal('attendance_ordain', 10, 2)->nullable()->default(0);
            $table->decimal('attendance_late', 10, 2)->nullable()->default(0);
            $table->decimal('attendance_absent', 10, 2)->nullable()->default(0);
            $table->decimal('attendance_warning', 10, 2)->nullable()->default(0);
            $table->decimal('attendance_suspension', 10, 2)->nullable()->default(0);

            $table->decimal('score_teamwork', 10, 2)->nullable();
            $table->decimal('score_communication', 10, 2)->nullable();
            $table->decimal('score_leadership', 10, 2)->nullable();
            $table->decimal('score_attitude', 10, 2)->nullable();
            $table->decimal('score_planning', 10, 2)->nullable();
            $table->decimal('score_ownership', 10, 2)->nullable();
            $table->decimal('score_problem_solving', 10, 2)->nullable();

            $table->decimal('score_dept_okr', 10, 2)->nullable();
            $table->decimal('score_company_okr', 10, 2)->nullable();
            $table->decimal('score_okr_reporting', 10, 2)->nullable();
            $table->decimal('score_system_smbr', 10, 2)->nullable();
            $table->decimal('score_bonus', 10, 2)->nullable();

            $table->decimal('supervisor_final_score', 10, 2)->nullable();
            $table->string('supervisor_grade', 30)->nullable();
            $table->string('supervisor_grade_text', 255)->nullable();

            $table->decimal('division_score_leadership', 10, 2)->nullable();
            $table->decimal('division_score_attitude', 10, 2)->nullable();
            $table->decimal('division_final_score', 10, 2)->nullable();
            $table->string('division_grade', 30)->nullable();
            $table->string('division_grade_text', 255)->nullable();

            $table->decimal('q_percent', 10, 2)->nullable();

            $table->timestamps();

            $table->unique(['cycle_id', 'employee_code'], 'uq_export_employee_history_cycle_employee');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('export_employee_history');
    }
};
