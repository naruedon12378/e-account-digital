<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Unit extends Model
{
    use HasFactory;

    protected $fillable = [
        "company_id",
        "code",
        "type",
        "name_en",
        "name_th",
        "description",
        "is_active",
        "created_by",
        "updated_by",
        "created_at",
        "updated_at",
    ];

    public function scopeMyCompany($query)
    {
        return $query->where('company_id', Auth::user()->company_id);
    }

    public function unit_set(){
        return $this->belongsTo(UnitSet::class, 'id', 'unit_id')->where('unit_parent_id',null);
    }

    public function unit_set_children(){
        return $this->hasMany(UnitSet::class, 'unit_id', 'id');
    }

    public function getActiveStyleAttribute()
    {
        $isActive = view('components.index.table-status',[
                        'role' => 'user',
                        'url' => 'unit/toggle_active/'.$this->id,
                        'data' => [
                            'id' => $this->id,
                            'isActive' => $this->is_active,
                        ],
                    ]);

        return $isActive;
    }

    public function getBtnEditAttribute()
    {
        $btnEdit = view('components.index.table-edit',[
                        'permissions' => ['*', 'all unit', 'edit unit'],
                        'url' => null,
                        'id' => $this->id,
                    ]);

        return $btnEdit;
    }

    public function getBtnDeleteAttribute()
    {
        $btnDelete = view('components.index.table-delete',[
                            'permissions' => ['*', 'all unit', 'delete unit'],
                            'url' => 'unit/'.$this->id,
                        ]);

        return $btnDelete;
    }
}
