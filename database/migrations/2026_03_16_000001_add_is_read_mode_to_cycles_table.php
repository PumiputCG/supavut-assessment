<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('cycles')) {
            return;
        }

        if (!Schema::hasColumn('cycles', 'is_read_mode')) {
            Schema::table('cycles', function (Blueprint $table) {
                $table->boolean('is_read_mode')->default(false)->after('is_active');
            });
        }
    }

    public function down(): void
    {
        if (!Schema::hasTable('cycles')) {
            return;
        }

        if (Schema::hasColumn('cycles', 'is_read_mode')) {
            Schema::table('cycles', function (Blueprint $table) {
                $table->dropColumn('is_read_mode');
            });
        }
    }
};
