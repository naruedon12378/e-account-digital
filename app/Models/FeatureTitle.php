<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeatureTitle extends Model
{
    use HasFactory;
    protected $table = 'feature_titles';
    protected $fillable = [
        'name_th',
        'name_en',
        'sort',
        'publish',
    ];

    public function features() {
        return $this->hasMany(FeatureList::class);
    }
}