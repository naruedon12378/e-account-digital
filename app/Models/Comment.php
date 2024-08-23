<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    protected $fillable = [
        'line_item_number',
        'table_name',
        'primary_key_name',
        'primary_key_value',
        'comment',
        "is_active",
        "company_id",
        'user_id',
    ];
}
