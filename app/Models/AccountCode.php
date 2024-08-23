<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccountCode extends Model
{
    use HasFactory;

    protected $appends = ['next_acc_code', 'next_running'];
    protected $fillable = [
        "primary_account_id",
        "secondary_account_id",
        "sub_account_id",
        "primary_prefix",
        "secondary_prefix",
        "sub_prefix",
        "running_number",
        "account_code",
        "name_en",
        "name_th",
        "description",
        "with_holding_tax_id",
        "income_tax_id",
        "sequence",
        "is_active",
        "company_id",
        "created_by",
        "updated_by",
        "created_at",
        "updated_at",
    ];

    public function primary()
    {
        return $this->belongsTo(PrimaryAccount::class, 'primary_account_id');
    }

    public function secondary()
    {
        return $this->belongsTo(SecondaryAccount::class, 'secondary_account_id');
    }

    public function subAccount()
    {
        return $this->belongsTo(SubAccount::class, 'sub_account_id');
    }

    public function getLocalNameAttribute()
    {
        return $this->name_th;
    }

    public function getNextAccCodeAttribute()
    {
        $lastRunnNumber = intval($this->running_number);
        $nextNumber = getRunningNumber($lastRunnNumber+1, 2);
        return $this->primary_prefix.$this->secondary_prefix.$this->sub_prefix.$nextNumber;
    }

    public function getNextRunningAttribute()
    {
        $lastRunnNumber = intval($this->running_number);
        return getRunningNumber($lastRunnNumber+1, 2);
    }
    
}
