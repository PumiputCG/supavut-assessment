<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('self_employees', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('cycle_id')->nullable()->index();
            $table->foreign('cycle_id')->references('id')->on('cycles')->nullOnDelete();

            $table->string('employee_code', 20)->index();

            $table->string('position', 100)->nullable();

 
            $table->unsignedTinyInteger('position_level')
                ->comment('1–5 ตาม level ที่ใช้ในระบบประเมิน');


            for ($i = 1; $i <= 27; $i++) {
                $table->unsignedTinyInteger("q{$i}")
                    ->nullable()
                    ->comment('0–5 คะแนนประเมินตัวเองในแต่ละข้อ');
            }

            $table->string('q_all', 20)
                ->nullable()
                ->comment('ผลรวมคะแนนตนเอง เช่น 28/35');

            $table->decimal('q_percent', 5, 2)
                ->nullable()
                ->comment('Self-score as percentage (sum/max * 100)');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('self_employees');
    }
};
