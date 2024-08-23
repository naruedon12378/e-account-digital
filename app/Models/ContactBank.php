<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactBank extends Model
{
    use HasFactory;

    protected $fillable = [
        'contact_id',
        'bank_id',
        'account_name',
        'account_number',
        'branch'
    ];
}
