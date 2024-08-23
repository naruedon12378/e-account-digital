<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class ProductComponentSetItem extends Model
{
    use HasFactory;
    protected $table = 'product_component_set_items';
    protected $fillable = [
        'product_component_set_id',
        'product_id',
        'amount',
        'created_by',
        'updated_by',
    ];

    public function product_component_set()
    {
        return $this->belongsTo(ProductComponentSet::class, 'product_component_set_id', 'id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

}
