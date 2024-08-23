<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class ProductComponentSet extends Model
{
    use HasFactory;

    protected $table = 'product_component_sets';

    protected $fillable = [
        'product_id',
        'amount',
        'slae_type',
        'created_by',
        'updated_by',
        'is_active',
    ];

    protected $casts = [
        'show_price' => 'boolean',
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

    public function getBtnDeleteAttribute()
    {
        $btnDelete = view('vendor.adminlte.components.form.table-delete',[
                            'permissions' => ['*', 'all product_set', 'delete product_set'],
                            'url' => 'productset/'.$this->id,
                        ]);

        return $btnDelete;
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    public function items(){
        return $this->hasMany(ProductComponentSetItem::class, 'product_component_set_id', 'id');
    }


}
