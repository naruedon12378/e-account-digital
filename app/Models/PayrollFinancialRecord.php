<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PayrollFinancialRecord extends Model
{
    use HasFactory;

    const REVENUE = 0; //เงินได้
    const DEDUCT = 1; //เงินหัก
    const IRREGULAR = 0; //ไม่ประจำ
    const REGULAR = 1; //ประจำ
    const ANNUAL_REVENUE_INCLUDE = 1; //คำนวณเงินได้ทั้งปี, รวมรายการนี้
    const ANNUAL_REVENUE_EXCLUDE = 0; //คำนวณเงินได้ทั้งปี, ไม่รวมรายการนี้
    const SSC_BASE_SALARY_INCLUDE = 1; //คำนวณฐานประกันสังคม, รวมรายการนี้
    const SSC_BASE_SALARY_EXCLUDE = 0; //คำนวณฐานประกันสังคม, ไม่รวมรายการนี้

    protected $table = 'payroll_financial_records';

    protected $fillable = [
        'code',
        'name_th',
        'name_en',
        'publish',
        'record_status',
        'type_form',
        'type',
        'type_account',
        'annual_revenue',
        'annual_revenue',
        'ssc_base_salary',
        'account_id',
        'company_id'
    ];

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function account()
    {
        return $this->belongsTo(AccountCode::class, 'account_id');
    }
}
