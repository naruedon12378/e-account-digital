<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PayrollSalarySummaryDetail extends Model
{
    use HasFactory;
    protected $fillable = [
        'payroll_salary_summary_id',
        'employee_id',
        'salary',
        'withholding_tax',
        'social_security',
        'total_revenue',
        'total_deduct',
        'net_salary',
    ];

    public function payrollSalarySummaryMoreDetails()
    {
        return $this->hasMany(PayrollSalarySummaryMoreDetail::class, 'payroll_salary_summary_detail_id');
    }
    public function employee()
    {
        return $this->belongsTo(PayrollEmployee::class, 'employee_id');
    }
}
