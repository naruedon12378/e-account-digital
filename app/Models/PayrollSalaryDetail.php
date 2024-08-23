<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PayrollSalaryDetail extends Model
{
    use HasFactory;
    protected $table = 'payroll_salary_details';
    protected $fillable = [
        'payroll_salary_id',
        'employee_id',
        'salary',
        'withholding_tax',
        'social_security',
        'pvd',
        'total_revenue',
        'total_deduct',
        'net_salary',
    ];

    public function payrollSalaryMoreDetails()
    {
        return $this->hasMany(PayrollSalaryMoreDetail::class, 'payroll_salary_detail_id');
    }
    public function employee()
    {
        return $this->belongsTo(PayrollEmployee::class, 'employee_id');
    }
}
