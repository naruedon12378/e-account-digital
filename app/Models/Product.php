<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        "item_class",
        "type",
        "code",
        "name_en",
        "name_th",
        "is_barcode",
        "barcode_symbology",
        "unit_id",
        "sale_price",
        "purchase_price",
        "sale_tax_id",
        "purchase_tax_id",
        "sale_account_id",
        "purchase_account_id",
        "cost_account_id",
        "is_cost_calculation",
        "cost_calculation",
        "qty",
        "min_qty",
        "product_details",
        "is_active",
        "company_id",
        "product_category_id",
        "created_by",
        "updated_by",
        "created_at",
        "updated_at",
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'details' => 'json',
    ];

    public function scopeMyCompany($query)
    {
        return $query->where('company_id', Auth::user()->company_id);
    }

    public function getActiveStyleAttribute()
    {
        $isActive = view('components.index.table-status',[
                        'role' => 'user',
                        'url' => 'products/toggle_active/'.$this->id,
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
                        'permissions' => ['*', 'all product', 'edit product'],
                        'url' => 'products/'.$this->id.'/edit',
                        'id' => $this->id,
                    ]);

        return $btnEdit;
    }

    public function getBtnDeleteAttribute()
    {
        $btnDelete = view('components.index.table-delete',[
                            'permissions' => ['*', 'all product', 'delete product'],
                            'url' => 'products/'.$this->id,
                        ]);

        return $btnDelete;
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class, 'unit_id', 'id');
    }

    public function product_category()
    {
        return $this->belongsTo(ProductCategory::class, 'product_category_id', 'id');
    }

    public function detail() {
        return $this->hasMany(ProductDetail::class, 'product_id', 'id');
    }

    public function product_prices() {
        return $this->hasMany(productPrice::class, 'product_id', 'id');
    }

    public function inventory() {
        return $this->hasOne(Inventory::class, 'product_id', 'id');
    }
}
