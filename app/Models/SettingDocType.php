<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SettingDocType extends Model
{
    use HasFactory;
    protected $table = 'setting_doc_types';
    protected $fillable = [
        'header',
        'special_characters',
        'year_type',
        'month_type',
        'date_type',
        'length_number_doc',
        'doc_type',
        'account_type',
        'remark',
        'company_id',
    ];
}
