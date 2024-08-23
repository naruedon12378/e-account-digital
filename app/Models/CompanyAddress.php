<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyAddress extends Model
{
    use HasFactory;
    protected $fillable = [
        "detail_th",
        "detail_en",
        "sub_district_th",
        "sub_district_en",
        "district_th",
        "district_en",
        "province_th",
        "province_en",
        "postcode",
        "company_id"
    ];

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }
}
