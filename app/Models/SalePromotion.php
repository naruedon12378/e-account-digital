<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class SalePromotion extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'sale_promotions';

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

    const coditions = [
        [
            'label' => 'Equal',
            'symbol' => '=',
            'value' => 'equal',
        ],
        [
            'label' => 'Greater than',
            'symbol' => '>',
            'value' => 'greater_than',
        ],
        [
            'label' => 'Greater than or Equal',
            'symbol' => '>=',
            'value' => 'greater_than_or_equal',
        ],
    ];

    public function scopeMyCompany($query)
    {
        return $query->where('company_id', Auth::user()->company_id);
    }

    public function getActiveStyleAttribute()
    {
        $isActive = view('vendor.adminlte.components.form.table-status',[
                        'role' => 'user',
                        'url' => 'salepromo/toggle_active/'.$this->id,
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
                        'permissions' => ['*', 'all sale_promotion', 'edit sale_promotion'],
                        'url' => 'salepromo/'.$this->id.'/edit',
                        'id' => $this->id,
                    ]);

        return $btnEdit;
    }

    public function getBtnDuplicateAttribute()
    {
        $btnDup = view('vendor.adminlte.components.form.table-duplicate',[
                        'permissions' => ['*', 'all sale_promotion', 'edit sale_promotion'],
                        'url' => 'salepromo/create?dupid='.$this->id,
                        'id' => $this->id,
                    ]);

        return $btnDup;
    }

    public function getBtnDeleteAttribute()
    {
        $btnDelete = view('vendor.adminlte.components.form.table-delete',[
                            'permissions' => ['*', 'all sale_promotion', 'delete sale_promotion'],
                            'url' => 'salepromo/'.$this->id,
                        ]);

        return $btnDelete;
    }

    public function items(){
        return $this->hasMany(SalePromotionItem::class, 'sale_promotion_id', 'id');
    }

}
