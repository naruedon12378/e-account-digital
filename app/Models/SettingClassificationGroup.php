<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SettingClassificationGroup extends Model
{
    use HasFactory;
    protected $table = 'setting_classification_groups';
    protected $fillable = [
        'classification_code',
        'name',
        'description',
        'publish_income',
        'publish_expense',
        'publish',
        'record_status',
        'company_id',
    ];

    public function settingClassificationBranches()
    {
        return $this->hasMany(SettingClassificationBranch::class, 'classification_group_id');
    }
}
