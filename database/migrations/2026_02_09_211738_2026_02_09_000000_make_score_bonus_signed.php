<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('employees') && Schema::hasColumn('employees', 'score_bonus')) {
            DB::statement("ALTER TABLE `employees` MODIFY `score_bonus` DECIMAL(4,2) NULL");
        }

        // ถ้าตาราง export_employees มี score_bonus ด้วย (ส่วนใหญ่มี) แนะนำแก้พร้อมกัน
        if (Schema::hasTable('export_employees') && Schema::hasColumn('export_employees', 'score_bonus')) {
            DB::statement("ALTER TABLE `export_employees` MODIFY `score_bonus` DECIMAL(4,2) NULL");
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('employees') && Schema::hasColumn('employees', 'score_bonus')) {
            DB::statement("ALTER TABLE `employees` MODIFY `score_bonus` DECIMAL(4,2) UNSIGNED NULL");
        }

        if (Schema::hasTable('export_employees') && Schema::hasColumn('export_employees', 'score_bonus')) {
            DB::statement("ALTER TABLE `export_employees` MODIFY `score_bonus` DECIMAL(4,2) UNSIGNED NULL");
        }
    }
};
