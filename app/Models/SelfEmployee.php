<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SelfEmployee extends Model
{
    use HasFactory;

    protected $table = 'self_employees';

    protected $fillable = [
      
        'cycle_id',

        'employee_code',
        'position',
        'position_level',
        // Q1–Q27
        'q1','q2','q3','q4','q5','q6','q7','q8','q9','q10',
        'q11','q12','q13','q14','q15','q16','q17','q18','q19','q20',
        'q21','q22','q23','q24','q25','q26','q27',
        'q_all',
        'q_percent',
    ];

    protected $casts = [
        'cycle_id' => 'integer',

        'position_level' => 'integer',
        'q1'  => 'integer',
        'q2'  => 'integer',
        'q3'  => 'integer',
        'q4'  => 'integer',
        'q5'  => 'integer',
        'q6'  => 'integer',
        'q7'  => 'integer',
        'q8'  => 'integer',
        'q9'  => 'integer',
        'q10' => 'integer',
        'q11' => 'integer',
        'q12' => 'integer',
        'q13' => 'integer',
        'q14' => 'integer',
        'q15' => 'integer',
        'q16' => 'integer',
        'q17' => 'integer',
        'q18' => 'integer',
        'q19' => 'integer',
        'q20' => 'integer',
        'q21' => 'integer',
        'q22' => 'integer',
        'q23' => 'integer',
        'q24' => 'integer',
        'q25' => 'integer',
        'q26' => 'integer',
        'q27' => 'integer',
        'q_percent' => 'float',
    ];

    public function cycle()
    {
        return $this->belongsTo(Cycle::class, 'cycle_id');
    }

  
    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_code', 'employee_code');
    }

  
    public function exportEmployee()
    {
        return $this->hasOne(ExportEmployee::class, 'employee_code', 'employee_code');
    }

    public function scopeInCycle($query, ?int $cycleId)
    {
        if (!$cycleId) return $query;
        return $query->where('cycle_id', $cycleId);
    }

    public function getTotalScoreAttribute(): int
    {
        $sum = 0;

        for ($i = 1; $i <= 27; $i++) {
            $value = $this->{"q{$i}"} ?? null;

            if ($value === null) {
                continue;
            }

            $value = (int) $value;

            if ($value >= 0 && $value <= 4) {
                $sum += $value;
            }
        }

        return $sum;
    }

    public function getMaxScoreForLevel(int $questionCount): int
    {
        return $questionCount * 4;
    }
}
