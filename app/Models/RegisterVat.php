<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegisterVat extends Model
{
    use HasFactory;
    protected $table = 'register_vats';
    protected $fillable = [
        'name_th',
        'name_en',
        'sort',
        'publish',
    ];
}
