<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Salary extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'employee_id',
        'month',
        'year',
        'basic_salary',
        'attendance_count',
        'absence_count',
        'deduction',
        'bonus',
        'total_salary',
        'notes',
        'is_paid',
        'paid_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'basic_salary' => 'decimal:2',
        'deduction' => 'decimal:2',
        'bonus' => 'decimal:2',
        'total_salary' => 'decimal:2',
        'is_paid' => 'boolean',
        'paid_at' => 'datetime',
    ];

    /**
     * Get the employee that owns the salary.
     */
    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    /**
     * Get formatted total salary
     */
    public function getFormattedTotalSalaryAttribute(): string
    {
        return 'Rp ' . number_format($this->total_salary, 0, ',', '.');
    }

    /**
     * Get period name (Month Year)
     */
    public function getPeriodAttribute(): string
    {
        $months = [
            '01' => 'Januari',
            '02' => 'Februari',
            '03' => 'Maret',
            '04' => 'April',
            '05' => 'Mei',
            '06' => 'Juni',
            '07' => 'Juli',
            '08' => 'Agustus',
            '09' => 'September',
            '10' => 'Oktober',
            '11' => 'November',
            '12' => 'Desember',
        ];

        return $months[$this->month] . ' ' . $this->year;
    }
}
