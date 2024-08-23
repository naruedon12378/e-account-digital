<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class ProductCategory extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $table = 'product_categories';

    protected $fillable = [
        "code",
        "name_en",
        "description",
        "cost_calculation_type",
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
                        'url' => 'productcategory/active/'.$this->id,
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
                        'permissions' => ['*', 'all product_category', 'edit product_category'],
                        'url' => null,
                        'id' => $this->id,
                    ]);

        return $btnEdit;
    }

    public function getBtnDeleteAttribute()
    {
        $btnDelete = view('vendor.adminlte.components.form.table-delete',[
                            'permissions' => ['*', 'all product_category', 'delete product_category'],
                            'url' => 'productcategory/'.$this->id,
                        ]);

        return $btnDelete;
    }

    public function product_type() {
        return $this->belongsTo( ProductType::class, 'product_type_id', 'id');
    }
}
