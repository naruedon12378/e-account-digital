<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatusTab extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'label', 'value', 'count', 'class', 'color'
    ];
}
