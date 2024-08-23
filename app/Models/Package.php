<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    use HasFactory;
    protected $table = 'packages';
    protected $fillable = [
        'name_th',
        'name_en',
        'description_th',
        'description_en',
        'price',
        'discount',
        'user_limit',
        'storage_limit',
        'sort',
        'publish',
    ];

    public function features() {
        return $this->belongsToMany(FeatureList::class, 'package_has_feature_lists');
    }
}
