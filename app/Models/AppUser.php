<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\Employee;
use App\Services\ExportEmployeeBuilder;

class AppUser extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $table = 'app_users';

    protected $fillable = [
        'username',
        'password',
        'id_thai_hash',
        'role',
        'profile_picture',
        'reset_token',
        'reset_token_expiry',
        'session_id',
        'is_registered',
        'registered_at',
        'remember_token',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'reset_token',
 
    ];

    protected $casts = [
        'reset_token_expiry' => 'datetime',
        'registered_at'      => 'datetime',
        'is_registered'      => 'boolean',
    ];

    protected static function booted()
    {
        static::saved(function (AppUser $user) {
     
            if (! $user->wasChanged(['is_registered'])) return;
            if (! $user->username) return;

            $employee = Employee::where('employee_code', $user->username)->first();
            if (! $employee) return;

            app(ExportEmployeeBuilder::class)->buildForEmployee($employee);
        });
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isSupOrDivManager(): bool
    {
        if (!$this->username) return false;

        return Employee::where('sup_id', $this->username)
            ->orWhere('div_mgr_id', $this->username)
            ->exists();
    }

    public function isDeptOrPlantManager(): bool
    {
        if (!$this->username) return false;

        return Employee::where('dept_mgr_id', $this->username)
            ->orWhere('plant_mgr_id', $this->username)
            ->exists();
    }

    public function canEvaluateSelf(): bool
    {
        return $this->role === 'user';
    }

    public function canEvaluateEmployees(): bool
    {
        return $this->role === 'user' && $this->isSupOrDivManager();
    }

    public function canViewEmployeesEvaluation(): bool
    {
        return $this->role === 'user' && $this->isDeptOrPlantManager();
    }

    public function employee()
    {
        return $this->hasOne(Employee::class, 'employee_code', 'username');
    }
}
