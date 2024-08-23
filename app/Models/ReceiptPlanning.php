<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReceiptPlanning extends Model
{
    use HasFactory;
    protected $table = 'receipt_plannings';
    protected $guarded = ['id'];
    protected $with = ['creator', 'receiver', 'checker', 'approver'];
    protected $fillable = [
        'company_id',
        'code',
        'currency_code',
        'tax_type',
        'title',
        'branch_id',
        'remark',
        'receipt_plan_datetime',
        'user_creator_id',
        'user_receiver_id',
        'user_checker_id',
        'user_approver_id',
        'status',
        'deleted_at',
        'is_active',
        'deleted_by',
        'created_by',
        'updated_by',
    ];

    public function getActiveStyleAttribute(){

        $isActive = view('components.index.table-status', [
            'role' => 'user',
            'url' => 'warehouse/receiptplanning/toggle_active/' . $this->id,
            'data' => [
                'id' => $this->id,
                'isActive' => $this->is_active,
            ],
        ]);

        return $isActive;
    }

    public function getBtnEditAttribute()
    {

        $btnEdit = view('components.index.table-edit', [
            'permissions' => ['*', 'all receiptplanning', 'edit receiptplanning'],
            'url' => 'warehouse/receiptplanning/' . $this->id . '/edit',
            'id' => $this->id,
        ]);

        return $btnEdit;
    }

    public function getBtnDeleteAttribute()
    {
        $btnDelete = view('components.index.table-delete', [
            'permissions' => ['*', 'all receiptplanning', 'delete receiptplanning'],
            'url' => 'warehouse/receiptplanning/' . $this->id,
        ]);

        return $btnDelete;
    }

    public function getStatusStyleAttribute()
    {
        $class = '';
        switch ($this->status) {
            case 'pending':
                $class = 'bg-warning';
                break;
            case 'approved':
                $class = 'bg-success';
                break;
            case 'reject':
                $class = 'bg-danger';
                break;
        }
        return '<span class="badge badge-' . $class . ' p-2">' . $this->status . '</span>';
    }



    public function company(){
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function branch(){
        return $this->belongsTo(Branch::class, 'branch_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'user_creator_id');
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, 'user_receiver_id');
    }

    public function checker()
    {
        return $this->belongsTo(User::class, 'user_checker_id');
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'user_approver_id');
    }

    public function items()
    {
        return $this->hasMany(IssueReturnStockItem::class, 'receipt_planning_id');
    }

    public function user_creator()
    {
        return $this->belongsTo(User::class, 'user_creator_id');
    }

    public function user_approver()
    {
        return $this->belongsTo(User::class, 'user_approver_id');
    }

}
