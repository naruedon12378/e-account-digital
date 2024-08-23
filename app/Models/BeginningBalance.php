<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class BeginningBalance extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $table = 'beginning_balances';
    protected $fillable = [
        'company_id',
        'code',
        'title',
        'created_date',
        'branch_id',
        'total_price',
        'remark',
        'user_creator_id',
        'user_checker_id',
        'user_approver_id',
        'user_receiver_id',
        'status',
        'currency_code',
        'tax_type',
        'is_active',
        'created_by',
        'updated_by',
        'deleted_by',
        'deleted_at',
    ];
    public function getActiveStyleAttribute()
    {
        $isActive = view('components.index.table-status', [
            'role' => 'user',
            'url' => 'warehouse/beginningbalance/toggle_active/' . $this->id,
            'data' => [
                'id' => $this->id,
                'isActive' => $this->is_active,
            ],
        ]);

        return $isActive;
    }
    public function getBtnEditAttribute()
    {
        $btnEdit = view('components.index.edit-link', [
            'permissions' => ['*', 'all beginningbalance', 'edit beginningbalance'],
            'url' => 'warehouse/beginningbalance/' . $this->id . '/edit',
            'name' => $this->code,
        ]);

        return $btnEdit;
    }
    public function getBtnDeleteAttribute()
    {
        $btnDelete = view('components.index.table-delete', [
            'permissions' => ['*', 'all beginningbalance', 'delete beginningbalance'],
            'url' => 'warehouse/beginningbalance/' . $this->id,
        ]);

        return $btnDelete;
    }
    public function getStatusStyleAttribute()
    {
        $class = '';
        switch ($this->status) {
            case 'pending':
                $class = 'secondary';
                break;
            case 'transferring':
                $class = 'warning';
                break;
            case 'approved':
                $class = 'success';
                break;
            case 'transferred':
                $class = 'success';
                break;
            case 'reject':
                $class = 'danger';
                break;
            default:
                $class = 'secondary';
                break;
        }
        return '<span class="badge badge-' . $class . ' p-2">' . $this->status . '</span>';
    }
    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id')->with('company_address');
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'user_creator_id');
    }

    public function checker()
    {
        return $this->belongsTo(User::class, 'user_checker_id');
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'user_approver_id');
    }
    public function receiver()
    {
        return $this->belongsTo(User::class, 'user_receiver_id');
    }

    public function items()
    {
        return $this->hasMany(BeginningBalanceItem::class, 'beginning_balance_id');
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
