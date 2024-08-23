<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class ProductDetail extends Model
{
    use HasFactory;
    protected $table = 'product_details';

    protected $fillable = [
        'product_id',
        'serial_no',
        'part_no',
    ];

    public function product(){
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

}
