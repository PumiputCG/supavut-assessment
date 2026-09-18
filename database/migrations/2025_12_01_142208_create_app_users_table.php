<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Carbon;
use App\Models\AppUser;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('app_users', function (Blueprint $table) {
            $table->id();

            $table->string('username', 100)->unique();

            $table->string('password')->nullable();
            $table->string('id_thai_hash', 255)->nullable();

            $table->string('role', 50)->default('user');

            $table->string('profile_picture')->nullable();

            $table->string('reset_token', 100)->nullable();
            $table->timestamp('reset_token_expiry')->nullable();

            $table->string('session_id')->nullable();

            $table->boolean('is_registered')->default(false)->index();
            $table->timestamp('registered_at')->nullable();

            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });

        if (!class_exists(AppUser::class)) {
            require_once app_path('Models/AppUser.php');
        }

        if (!AppUser::where('username', 'admin')->exists()) {
            AppUser::create([
                'username'      => 'admin',
                'password'      => Hash::make('00000000'),
                'role'          => 'admin',
                'is_registered' => true,
                'registered_at' => Carbon::now(),
            ]);
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('app_users');
    }
};
