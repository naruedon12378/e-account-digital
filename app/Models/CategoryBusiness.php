<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryBusiness extends Model
{
    use HasFactory;
    protected $table = 'category_businesses';
    protected $fillable = [
        'name_th',
        'name_en',
        'sort',
        'publish',
        'type_business_id',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
