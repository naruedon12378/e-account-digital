<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SettingDueDate extends Model
{
    use HasFactory;
    protected $table = 'setting_due_dates';
    protected $fillable = [
        'transaction_type',
        'format',
        'period',
        'company_id',
        'created_by',
        'updated_by',
    ];
}
