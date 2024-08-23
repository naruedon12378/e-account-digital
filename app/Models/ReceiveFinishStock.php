<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReceiveFinishStock extends Model
{
    use HasFactory;
    protected $table = 'receive_finish_stocks';
    protected $guarded = [ 'id' ];
    protected $fillable = [
        'company_id',
        'receipt_planning_id',
        'receipt_document_code',
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
        'created_date',
        'is_active',
        'created_at',
        'updated_at',
        'deleted_at',
        'deleted_by',
    ];


    public function getActiveStyleAttribute(){

        $isActive = view('components.index.table-status', [
            'role' => 'user',
            'url' => 'warehouse/receivefinishstock/toggle_active/' . $this->id,
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
            'permissions' => ['*', 'all receivefinishstock', 'edit receivefinishstock'],
            'url' => 'warehouse/receivefinishstock/' . $this->id . '/edit',
            'id' => $this->id,
        ]);

        return $btnEdit;
    }

    public function getBtnDeleteAttribute()
    {

        $btnDelete = view('components.index.table-delete', [
            'permissions' => ['*', 'all receivefinishstock', 'delete receivefinishstock'],
            'url' => 'warehouse/receivefinishstock/' . $this->id,
        ]);

        return $btnDelete;
    }

    public function getStatusStyleAttribute()
    {
        $class = '';
        switch ($this->status) {
            case 'waiting':
                $class = 'bg-warning';
                break;
            case 'approved':
                $class = 'bg-success';
                break;
            case 'rejected':
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

    public function planning()
    {
        return $this->belongsTo(ReceiptPlanning::class, 'receipt_planning_id');
    }
}
