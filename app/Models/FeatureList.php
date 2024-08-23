<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeatureList extends Model
{
    use HasFactory;
    protected $table = 'feature_lists';
    protected $fillable = [
        'name_th',
        'name_en',
        'sort',
        'publish',
        'feature_title_id',
    ];

    public function feature_title() {
        return $this->belongsTo(FeatureTitle::class);
    }

    public function features() {
        return $this->belongsToMany(FeatureList::class);
    }

    public function packages() {
        return $this->belongsToMany(Package::class, 'package_has_feature_lists');
    }
}