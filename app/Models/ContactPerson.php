<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactPerson extends Model
{
    use HasFactory;
    protected $table = 'contact_persons';

    protected $fillable = [
        'contact_id',
        'prefix',
        'first_name',
        'last_name',
        'nick_name',
        'email',
        'phone',
        'position',
        'department',
    ];
}
