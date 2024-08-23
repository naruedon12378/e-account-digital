<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Company extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;
    protected $table = 'companies';
    protected $fillable = [
        'company_code',
        'tax_number',
        'name_th',
        'name_en',
        'branch',
        'branch_no',
        'branch_name',
        'publish',
        'phone',
        'fax_number',
        'line',
        'email',
        'website',
        'vat_status',
        'social_security_status',
        'business_registration_date',
        'vat_registration_date',
        'date_expired',
        'description',
        'type_business_id',
        'category_business_id',
        'register_vat_id',
        'user_id',
        'type_registration',
        'pvd_status',
        'pvd_rate',
        'paid_salary_account_id',
        'day_of_paid_salary',
    ];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('company_logo');
        $this->addMediaCollection('company_stamp');
    }

    public function company_address()
    {
        return $this->hasOne(CompanyAddress::class, 'company_id');
    }

    public function type_business()
    {
        return $this->hasOne(TypeBusiness::class);
    }

    public function category_business()
    {
        return $this->hasOne(CategoryBusiness::class);
    }

    public function payroll_departments()
    {
        return $this->hasMany(PayrollDepartment::class);
    }

    public function payroll_financial_records()
    {
        return $this->hasMany(PayrollFinancialRecord::class);
    }
}
