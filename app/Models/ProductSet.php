<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class ProductSet extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'product_sets';

    protected $fillable = [
        'code',
        'name_th',
        'name_en',
        'sale_price',
        'amount',
        'slae_type',
        'created_by',
        'updated_by',
        'is_active',
        'show_set_price',
        'show_item_price',
    ];

    protected $casts = [
        'show_set_price' => 'boolean',
        'show_item_price' => 'boolean',
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
                        'url' => 'productset/toggle_active/'.$this->id,
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
                        'permissions' => ['*', 'all product_set', 'edit product_set'],
                        'url' => 'productset/'.$this->id.'/edit',
                        'id' => $this->id,
                    ]);

        return $btnEdit;
    }

    public function getBtnDuplicateAttribute()
    {
        $btnEdit = view('vendor.adminlte.components.form.table-duplicate',[
                        'permissions' => ['*', 'all product_set', 'edit product_set'],
                        'url' => 'productset/create?dupid='.$this->id,
                        'id' => $this->id,
                    ]);

        return $btnEdit;
    }

    public function getBtnDeleteAttribute()
    {
        $btnDelete = view('vendor.adminlte.components.form.table-delete',[
                            'permissions' => ['*', 'all product_set', 'delete product_set'],
                            'url' => 'productset/'.$this->id,
                        ]);

        return $btnDelete;
    }

    public function items(){
        return $this->hasMany(ProductSetItem::class, 'product_set_id', 'id');
    }


}
