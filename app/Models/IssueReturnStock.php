<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IssueReturnStock extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $table = 'issue_return_stocks';
    protected $fillable = [
        'company_id',
        'code',
        'currency_code',
        'tax_type',
        'title',
        'branch_id',
        'remark',
        'user_creator_id',
        'user_checker_id',
        'user_approver_id',
        'status',
        'is_active',
        'deleted_by',
        'deleted_at',
        'created_by',
        'updated_by',
    ];

    public function getActiveStyleAttribute()
    {
        $isActive = view('components.index.table-status', [
            'role' => 'user',
            'url' => 'warehouse/issuereturnstock/toggle_active/' . $this->id,
            'data' => [
                'id' => $this->id,
                'isActive' => $this->is_active,
            ]
        ]);

        return $isActive;
    }

    public function getBtnEditAttribute()
    {
        $btnEdit = view('components.index.table-edit', [
            'permissions' => ['*', 'all issuereturnstock', 'edit issuereturnstock'],
            'url' => 'warehouse/issuereturnstock/' . $this->id . '/edit',
            'id' => $this->id,
        ]);

        return $btnEdit;
    }

    public function getBtnDeleteAttribute()
    {
        $btnDelete = view('components.index.table-delete', [
            'permissions' => ['*', 'all issuereturnstock', 'delete issuereturnstock'],
            'url' => 'warehouse/issuereturnstock/' . $this->id,
        ]);

        return $btnDelete;
    }

    public function getBtnDetailAttribute()
    {
        $btnDetail = view('components.index.table-detail', [
            'url' => 'warehouse/issuereturnstock/' . $this->id,
        ]);

        return $btnDetail;
    }

    public function getShowLinkAttribute()
    {
        $btnEdit = view('components.index.edit-link', [
            'permissions' => ['*', 'all issuereturnstock', 'edit issuereturnstock'],
            'url' => 'warehouse/issuereturnstock/' . $this->id,
            'name' => $this->code,
        ]);

        return $btnEdit;
    }

    public function getStatusStyleAttribute()
    {
        $class = '';
        switch ($this->status) {
            case 'pending':
                $class = 'secondary';
                break;
            case 'approved':
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

    public function getBranchNameAttribute()
    {
        $branch = Branch::where('id', $this->branch_id)->first();
        return $branch->name;
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id');
    }

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function user_creator()
    {
        return $this->belongsTo(User::class, 'user_creator_id');
    }

    public function user_checker()
    {
        return $this->belongsTo(User::class, 'user_checker_id');
    }

    public function user_approver()
    {
        return $this->belongsTo(User::class, 'user_approver_id');
    }

    public function issue_return_stock_items()
    {
        return $this->hasMany(IssueReturnStockItem::class, 'issue_return_stock_id');
    }

    public function items()
    {
        return $this->hasMany(IssueReturnStockItem::class, 'issue_return_stock_id');
    }

}
