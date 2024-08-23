<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PackageHasFeatureList extends Model
{
    use HasFactory;
    protected $table = 'package_has_feature_lists';
    protected $fillable = [
        'feature_list_id',
        'package_id',
    ];
}
