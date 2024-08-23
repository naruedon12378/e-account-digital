<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PayrollDepartment extends Model
{
    use HasFactory;

    protected $table = 'payroll_departments';

    protected $fillable = [
        'name_th',
        'name_en',
        'publish',
        'account_id',
        'company_id',
    ];

    public function company() {
        return $this->belongsTo(Company::class);
    }
}