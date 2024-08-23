<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OfficeAddress extends Model
{
    use HasFactory;

    protected $fillable = [
        'contact_id',
        'contact_name',
        'address',
        'province_id',
        'amphure_id',
        'district_id',
        'postcode',
    ];
}
