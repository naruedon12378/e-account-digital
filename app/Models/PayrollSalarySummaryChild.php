<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PayrollSalarySummaryChild extends Model
{
    use HasFactory;
    protected $fillable = [
        'payroll_salary_summary_detail_id',
        'payroll_salary_id',
    ];

    public function payrollSalaries()
    {
        return $this->hasMany(PayrollSalary::class, 'payroll_salary_id');
    }
}
