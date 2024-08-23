<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class UnitSet extends Model
{
    use HasFactory;
    protected $table = 'unit_sets';

    protected $fillable = [
        'company_id',
        'unit_parent_id',
        'unit_id',
        'amount',
        'is_active',
        'description',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // public function newQuery($excludeDeleted = true) {
    //     return parent::newQuery($excludeDeleted)
    //         ->where('company_id', Auth::user()->company_id);
    // }

    public function scopeMyCompany($query)
    {
        return $query->where('company_id', Auth::user()->company_id);
    }

    public function getActiveStyleAttribute(){
        $isActive = view('components.index.table-status',[
            'role' => 'unitset',
            'url' => 'unit/is_active/'.$this->id,
            'data' => [
                'id' => $this->id,
                'isActive' => $this->is_active,
            ],
        ]);

        return $isActive;
    }

    public function getBtnEditAttribute(){
        return view('vendor.adminlte.components.form.table-edit',[
            'permissions' => ['*', 'all unit_set', 'edit unit_set'],
            'url' => 'unitset/'.$this->id.'/edit',
            'id' => $this->id,
        ]);
    }

    public function getBtnDeleteAttribute(){
        return view('vendor.adminlte.components.form.table-delete',[
            'permissions' => ['*', 'all unit_set', 'edit unit_set'],
            'url' => 'unitset/'.$this->id,
            'id' => $this->id,
        ]);
    }

    public function getBtnActiveAttribute(){
        return view('vendor.adminlte.components.form.table-active',[
            'url' => 'unitset/'.$this->id,
            'id' => $this->id,
        ]);
    }

    public function children(){
        return $this->hasMany(UnitSet::class, 'unit_parent_id', 'unit_id');
    }

    public function unit(){
        return $this->belongsTo(Unit::class,'unit_id');
    }

    // public function unitParent(){
    //     return $this->belongsTo(Unit::class,'unit_parent_id');
    // }

    public function company(){
        return $this->belongsTo(Company::class,'company_id');
    }

}
