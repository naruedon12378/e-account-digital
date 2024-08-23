<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseOrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'purchase_order_id',
        'line_item_no',
        'code',
        'name',
        'account_code',
        'qty',
        'price',
        'discount',
        'vat_rate',
        'vat_amt',
        'wht_rate',
        'wht_amt',
        'pre_vat_amt',
        'description',
        'created_at',
        'updated_at',
    ];  
}
