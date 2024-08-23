<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Inventory extends Model
{
    use HasFactory;
    protected $table = 'inventories';

    protected $fillable = [
        'warehouse_id',
        'product_id',
        'amount',
        'is_negative_amount',
        'limit_min_amount',
        'limit_max_amount',
        'limit_amount_notification',
        'is_negative_amount',
        'location',
        'description',
        'status',
    ];

    protected $casts = [
        'is_negative_amount' => 'boolean',
        'limit_amount_notification' => 'boolean',
    ];

    public function scopeMyCompany($query)
    {
        return $query->where('company_id', Auth::user()->company_id);
    }

    public function getBtnViewAttribute()
    {
        $btnView = '';
        if( Auth::user()->hasAnyPermission(['*', 'all inventory', 'view inventory']) ){
            $btnView = '<a class="btn btn-outline-success btn-sm js-adjust" data-id="'.$this->id.'" href=" '.url('warehouse/inventory/'.$this->id).'"><i class="fas fa-box-open " data-toggle="tooltip" title="ดูข้อมูล"></i> ดูข้อมูล</a>';
        }

        return $btnView;
    }

    public function getBtnEditAttribute()
    {
        $btnEdit = view('vendor.adminlte.components.form.table-edit',[
                            'permissions' => ['*', 'all inventory', 'edit inventory'],
                            'url' => null,
                            'id' => $this->id,
                        ]);

        $btnEdit = str_replace("success", "primary", $btnEdit);

        return $btnEdit;
    }

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class,'warehouse_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function inventory_stock()
    {
        return $this->hasMany(InventoryStock::class, 'inventory_id');
    }
}
