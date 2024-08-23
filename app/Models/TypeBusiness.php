<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeBusiness extends Model
{
    use HasFactory;
    protected $table = 'type_businesses';
    protected $fillable = [
        'name_th',
        'name_en',
        'percent',
        'sort',
        'publish',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
