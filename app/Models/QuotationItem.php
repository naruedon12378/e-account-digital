<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuotationItem extends Model
{
    use HasFactory;
    protected $fillable = [
        "quotation_id",
        "line_item_no",
        "code",
        "name",
        "qty",
        "price",
        "vat_rate",
        "vat_amt",
        "wht_rate",
        "wht_amt",
        "pre_vat_amt",
        "description",
        "created_at",
        "updated_at",
    ];
}
