<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class PayrollEmployee extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;
    protected $table = 'payroll_employees';
    protected $fillable = [
        'profie_img',
        'citizen_no',
        'citizen_file',
        'start_date',
        'prefix_id',
        'first_name_th',
        'mid_name_th',
        'last_name_th',
        'first_name_en',
        'mid_name_en',
        'last_name_en',
        'department_id',
        'contract_type',
        'position',
        'email',
        'phone',
        'urgent_name',
        'urgent_phone',
        'address',
        'sub_district',
        'district',
        'province',
        'zipcode',
        'salary',
        'account_id',
        'scc_chkbox',
        'tax_holding_chkbox',
        'tax_holding',
        'pnd_type',
        'payment_channel',
        'bank_id',
        'account_type',
        'account_name',
        'account_number',
        'branch_name',
        'branch_code',
        'type_form',
        'promptpay_type',
        'promptpay_number',
        'company_id',
        'record_status',
    ];

    protected $appends = ['fullname'];

    public static $field_name = [];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        self::$field_name = $this->fillable;
    }

    public function getName()
    {
        $name_th = $this->first_name_th . ' ' . $this->mid_name_th . ' ' . $this->last_name_th;
        $name_en = $this->first_name_en . ' ' . $this->mid_name_en . ' ' . $this->last_name_en;
        return compact('name_th', 'name_en');
    }

    public function getFullnameAttribute()
    {
        return $this->getName();
    }

    public function bank()
    {
        return $this->belongsTo(Bank::class, 'bank_id');
    }
    public function prefix()
    {
        return $this->belongsTo(UserPrefix::class, 'prefix_id');
    }
    public function account()
    {
        return $this->belongsTo(ChartOfAccount::class, 'account_id');
    }
    public function department()
    {
        return $this->belongsTo(PayrollDepartment::class, 'department_id');
    }
    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }
}
