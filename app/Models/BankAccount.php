<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BankAccount extends Model
{
    use HasFactory;
    protected $table = 'bank_accounts';
    protected $fillable = [
        'bank_code',
        'advance_type',
        'financial_type',
        'account_type',
        'account_name',
        'account_number',
        'branch_name',
        'branch_code',
        'name_reverse_payment',
        'service_provider_type',
        'service_provider_id',
        'remark',
        'income_status',
        'expense_status',
        'pay_check_status',
        'bank_id',
        'chart_account_id',
        'company_id',
    ];

    public function bank()
    {
        return $this->belongsTo(Bank::class, 'bank_id');
    }
}
