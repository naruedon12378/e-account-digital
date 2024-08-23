<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PayrollSalarySummary extends Model
{
    use HasFactory;
    public static $status = [
        0 => 'แบบร่าง',
        1 => 'รออนุมัติ',
        2 => 'รอชำระ',
        3 => 'ชำระแล้ว',
        4 => 'ถังขยะ',
    ];
    protected $fillable = [
        'code',
        'issue_date',
        'due_date',
        'from_date',
        'to_date',
        'total',
        'sum_revenue_item',
        'sum_deduct_item',
        'sum_holding_tax',
        'employee_social_security',
        'company_social_security',
        'payable_social_security',
        'payable_holding_tax',
        'net_amount',
        'emp_count',
        'company_id',
        'status',
    ];

    public function payrollSalarySummaryDetails()
    {
        return $this->hasMany(PayrollSalarySummaryDetail::class, 'payroll_salary_summary_id');
    }
    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }
}
