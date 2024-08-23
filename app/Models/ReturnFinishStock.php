<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReturnFinishStock extends Model
{
    use HasFactory;

    protected $guarded = [ 'id' ];
    protected $table = 'return_finish_stocks';
    protected $fillable = [
        'company_id',
        'code',
        'currency_code',
        'tax_type',
        'title',
        'branch_id',
        'remark',
        'user_creator_id',
        'user_receiver_id',
        'user_checker_id',
        'user_approver_id',
        'status',
        'is_active',
        'deleted_by',
        'deleted_at',
        'created_by',
        'updated_by'
    ];

     public function getActiveStyleAttribute(){

        $isActive = view('components.index.table-status', [
            'role' => 'user',
            'url' => 'warehouse/returnfinishstock/toggle_active/' . $this->id,
            'data' => [
                'id' => $this->id,
                'isActive' => $this->is_active,
            ],
        ]);

        return $isActive;
     }

    public function getBtnEditAttribute(){
        $btnEdit = view('components.index.table-edit', [
            'permissions' => ['*', 'all returnfinishstock', 'edit returnfinishstock'],
            'url' => 'warehouse/returnfinishstock/' . $this->id . '/edit',
            'id' => $this->id,
        ]);

        return $btnEdit;

    }

    public function getBtnDeleteAttribute()
    {
        $btnDelete = view('components.index.table-delete', [
            'permissions' => ['*', 'all returnfinishstock', 'delete returnfinishstock'],
            'url' => 'warehouse/returnfinishstock/' . $this->id,
        ]);

        return $btnDelete;
    }

    public function getStatusStyleAttribute()
    {
        $class = '';
        switch ($this->status) {
            case 'pending':
                $class = 'badge badge-warning';
                break;
            case 'approved':
                $class = 'badge badge-success';
                break;
            case 'reject':
                $class = 'badge badge-danger';
                break;
            default:
                $class = 'badge badge-primary';
                break;
        }

        return '<span class="badge badge-' . $class . ' p-2">' . $this->status . '</span>';
    }

    public function company()
    {
        return $this->belongsTo(Company::class , 'company_id');
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class , 'branch_id');
    }

    public function user_creator()
    {
        return $this->belongsTo(User::class , 'user_creator_id');
    }

    public function user_receiver()
    {
        return $this->belongsTo(User::class , 'user_receiver_id');
    }

    public function user_checker()
    {
        return $this->belongsTo(User::class , 'user_checker_id');
    }

    public function user_approver()
    {
        return $this->belongsTo(User::class , 'user_approver_id');
    }

    public function return_finish_stock_items()
    {
        return $this->hasMany(ReturnFinishStockItem::class , 'return_finish_stock_id');
    }

    public function items()
    {
        return $this->hasMany(ReturnFinishStockItem::class, 'return_finish_stock_id');
    }

}
