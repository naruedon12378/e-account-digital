<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransferStock extends Model
{
    use HasFactory;
    protected $table = 'transfer_stocks';

    protected $guarded = ['id'];
    protected $fillable = ['inventory_id', 'code', 'document_number', 'condition_type', 'user_creator_id', 'user_counter_id', 'user_approver_id', 'remark', 'created_by', 'updated_by'];


    public function inventory()
    {
        return $this->belongsTo(Inventory::class, 'inventory_id');
    }

    public function user_creator()
    {
        return $this->belongsTo(User::class, 'user_creator_id');
    }

    public function user_counter()
    {
        return $this->belongsTo(User::class, 'user_counter_id');
    }

    public function user_approver()
    {
        return $this->belongsTo(User::class, 'user_approver_id');
    }

    public function transfer_stock_items()
    {
        return $this->hasMany(TransferStockItem::class, 'transfer_stock_id');
    }

    public function transfer_requistion()
    {
        return $this->hasMany(TransferRequistion::class, 'transfer_stock_id');
    }

}
