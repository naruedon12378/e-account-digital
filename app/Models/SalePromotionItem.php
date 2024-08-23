<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class SalePromotionItem extends Model
{
    use HasFactory;

    protected $table = 'sale_promotion_items';

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function sale_promotion(){
        return $this->belongsTo(SalePromotion::class, 'product_set_id', 'id');
    }


}
