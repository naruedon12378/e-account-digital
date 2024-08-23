<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class productPrice extends Model
{
    use HasFactory;
    protected $table = 'product_prices';

    protected $fillable = [
        'product_id',
        'price',
        'level',
    ];

    public function product(){
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

}
