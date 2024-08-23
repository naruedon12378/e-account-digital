<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    use HasFactory;
    protected $table = 'activity_logs';
    protected $fillable = [
        'line_item_number',
        'table_name',
        'primary_key_name',
        'primary_key_value',
        'activity',
        'is_active',
        'company_id',
        'user_id',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at'
    ];
}
