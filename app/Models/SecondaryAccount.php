<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SecondaryAccount extends Model
{
    use HasFactory;
    
    protected $appends = ['local_name'];
    protected $fillable = [
        "primary_account_id",
        "primary_prefix",
        "prefix",
        "name_en",
        "name_th",
        "sequence",
        "is_active",
        "created_by",
        "updated_by",
        "created_at",
        "updated_at",
    ];

    public function getLocalNameAttribute()
    {
        return $this->name_th;
    }

    
}
