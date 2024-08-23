<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PayrollSalaryMoreDetail extends Model
{
    use HasFactory;
    protected $table = 'payroll_salary_more_details';
    protected $fillable = [
        'payroll_salary_detail_id',
        'payroll_salary_financial_record_id',
        'value',
    ];

    public function payrollFinancialRecord()
    {
        return $this->belongsTo(PayrollFinancialRecord::class, 'payroll_salary_financial_record_id');
    }
}
