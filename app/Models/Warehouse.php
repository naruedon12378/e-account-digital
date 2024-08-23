<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Warehouse extends Model
{
    use HasFactory;
    protected $table = 'warehouses';
    // protected $fillable = [
    //     'name',
    //     'is_active',
    //     'user_creator_id',
    //     'user_modifier_id',
    //     'created_by',
    //     'updated_by',
    // ];
    protected $fillable = [
        'name_en',
        'name_th',
        'company_id',
        'branch_id',
        'code',
        'is_active',
        'user_creator_id',
        'user_modifier_id',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function scopeMyCompany($query)
    {
        return $query->where('company_id', Auth::user()->company_id);
    }

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id');
    }

    public function getActiveStyleAttribute()
    {
        $isActive = view('vendor.adminlte.components.form.table-status', [
            'role' => 'user',
            'url' => 'warehouse/warehouse/active/' . $this->id,
            'data' => [
                'id' => $this->id,
                'isActive' => $this->is_active,
            ],
        ]);

        return $isActive;
    }
}
