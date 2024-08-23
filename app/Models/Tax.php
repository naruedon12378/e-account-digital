<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tax extends Model
{
    use HasFactory;

    protected $fillable = [
        "code",
        "name_en",
        "name_th",
        "is_include",
        "rate",
        "input_account_id",
        "output_account_id",
        "paid_input_account_id",
        "paid_output_account_id",
        "sequence",
        "is_active",
        "created_by",
        "updated_by",
        "created_at",
        "updated_at",
    ];
}
