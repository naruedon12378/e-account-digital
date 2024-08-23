<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransferRequistion extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $table = 'transfer_requistions';
    protected $fillable = [
        'company_id',
        'code',
        'currency_code',
        'tax_type',
        'title',
        'type',
        'from_branch_id',
        'from_location',
        'to_branch_id',
        'to_location',
        'remark',
        'user_creator_id',
        'user_drawer_id',
        'user_checker_id',
        'user_approver_id',
        'user_drawee_id',
        'user_receiver_id',
        'status',
        'is_active',
        'deleted_by',
        'created_by',
        'updated_by',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function user_creator()
    {
        return $this->belongsTo(User::class, 'user_creator_id');
    }

    public function user_drawer()
    {
        return $this->belongsTo(User::class, 'user_drawer_id');
    }

    public function user_checker()
    {
        return $this->belongsTo(User::class, 'user_checker_id');
    }

    public function user_approver()
    {
        return $this->belongsTo(User::class, 'user_approver_id');
    }

    public function user_drawee()
    {
        return $this->belongsTo(User::class, 'user_drawee_id');
    }

    public function user_receiver()
    {
        return $this->belongsTo(User::class, 'user_receiver_id');
    }
    function from_branch()
    {
        return $this->belongsTo(Branch::class, 'from_branch_id');
    }
    function to_branch()
    {
        return $this->belongsTo(Branch::class, 'to_branch_id');
    }

    public function items()
    {
        return $this->hasMany(TransferRequistionItem::class, 'transfer_requistion_id');
    }
}
