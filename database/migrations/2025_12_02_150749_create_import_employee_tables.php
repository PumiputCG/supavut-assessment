<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();

            $table->string('employee_code')->unique();
            $table->string('citizen_id', 50)->nullable();

            $table->string('full_name_th')->nullable();
            $table->string('full_name_en')->nullable();
            $table->string('employee_type')->nullable();
            $table->string('position')->nullable();
            $table->string('department')->nullable();

            $table->string('dept_abbr_qms')->nullable();
            $table->string('dept_abbr_hr')->nullable();

            $table->string('sup_id')->nullable();
            $table->string('sup_name')->nullable();

            $table->string('div_mgr_id')->nullable();
            $table->string('div_mgr_name')->nullable();

            $table->string('dept_mgr_id')->nullable();
            $table->string('dept_mgr_name')->nullable();

            $table->string('plant_mgr_id')->nullable();
            $table->string('plant_mgr_name')->nullable();

            $table->unsignedTinyInteger('position_level')->nullable();

            $table->decimal('attendance_total', 6, 2)->unsigned()->nullable();
            $table->decimal('attendance_sick', 6, 2)->unsigned()->nullable();
            $table->decimal('attendance_personal', 6, 2)->unsigned()->nullable();
            $table->decimal('attendance_maternity', 6, 2)->unsigned()->nullable();
            $table->decimal('attendance_ordain', 6, 2)->unsigned()->nullable();
            $table->decimal('attendance_late', 6, 2)->unsigned()->nullable();
            $table->decimal('attendance_absent', 6, 2)->unsigned()->nullable();

            $table->decimal('attendance_warning', 6, 2)->unsigned()->nullable();
            $table->decimal('attendance_suspension', 6, 2)->unsigned()->nullable();

            $table->decimal('score_teamwork', 4, 2)->unsigned()->nullable();
            $table->decimal('score_communication', 4, 2)->unsigned()->nullable();

            $table->decimal('score_leadership', 4, 2)->unsigned()->nullable();
            $table->decimal('score_attitude', 4, 2)->unsigned()->nullable();

            $table->decimal('score_planning', 4, 2)->unsigned()->nullable();
            $table->decimal('score_ownership', 4, 2)->unsigned()->nullable();
            $table->decimal('score_problem_solving', 4, 2)->unsigned()->nullable();

            $table->decimal('score_dept_okr', 4, 2)->unsigned()->nullable();
            $table->decimal('score_company_okr', 4, 2)->unsigned()->nullable();
            $table->decimal('score_okr_reporting', 4, 2)->unsigned()->nullable();
            $table->decimal('score_system_smbr', 4, 2)->unsigned()->nullable();

            $table->decimal('score_bonus', 4, 2)->unsigned()->nullable();

            $table->decimal('division_score_leadership', 4, 2)->unsigned()->nullable();
            $table->decimal('division_score_attitude', 4, 2)->unsigned()->nullable();

            $table->timestamps();

            $table->index(['dept_abbr_qms']);
            $table->index(['sup_id']);
            $table->index(['div_mgr_id']);
            $table->index(['dept_mgr_id']);
            $table->index(['plant_mgr_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
