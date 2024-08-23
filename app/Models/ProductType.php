<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class ProductType extends Model
{
    use HasFactory;

    protected $table = 'product_types';

    protected $fillable = [
        "code",
        "name_en",
        "description"
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function scopeMyCompany($query)
    {
        return $query->where('company_id', Auth::user()->company_id);
    }

    public function getActiveStyleAttribute()
    {
        $isActive = view('vendor.adminlte.components.form.table-status',[
                        'role' => 'user',
                        'url' => 'producttype/active/'.$this->id,
                        'data' => [
                            'id' => $this->id,
                            'isActive' => $this->is_active,
                        ],
                    ]);

        return $isActive;
    }

    public function getBtnEditAttribute()
    {
        $btnEdit = view('vendor.adminlte.components.form.table-edit',[
                        'permissions' => ['*', 'all product_type', 'edit product_type'],
                        'url' => null,
                        'id' => $this->id,
                    ]);

        return $btnEdit;
    }

    public function getBtnDeleteAttribute()
    {
        $btnDelete = view('vendor.adminlte.components.form.table-delete',[
                            'permissions' => ['*', 'all product_type', 'delete product_type'],
                            'url' => 'producttype/'.$this->id,
                        ]);

        return $btnDelete;
    }
}
