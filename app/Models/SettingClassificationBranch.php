<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SettingClassificationBranch extends Model
{
    use HasFactory;
    protected $table = 'setting_classification_branches';
    protected $fillable = [
        'classification_branch_code',
        'name',
        'description',
        'publish',
        'classification_group_id',
    ];
}
