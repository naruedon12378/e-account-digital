<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IssueRequisition extends Model
{
    use HasFactory;
    protected $table = 'issue_requisitions';
    protected $fillable = [
        'company_id',
        'code',
        'title',
        'branch_id',
        'remark',
        'user_creator_id',
        'user_checker_id',
        'user_approver_id',
        'status',
        'is_active',
        'created_by',
        'updated_by',
    ];
    public function getActiveStyleAttribute()
    {
        $isActive = view('components.index.table-status', [
            'role' => 'user',
            'url' => 'warehouse/issuerequisition/toggle_active/' . $this->id,
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
            'permissions' => ['*', 'all issuerequisition', 'edit issuerequisition'],
            'url' => 'warehouse/issuerequisition/' . $this->id . '/edit',
            'id' => $this->id,
        ]);

        return $btnEdit;
    }

    public function getBtnDeleteAttribute()
    {
        $btnDelete = view('components.index.table-delete', [
            'permissions' => ['*', 'all issuerequisition', 'delete issuerequisition'],
            'url' => 'warehouse/issuerequisition/' . $this->id,
        ]);

        return $btnDelete;
    }

    public function getBtnDetailAttribute()
    {
        $btnDetail = view('components.index.table-detail', [
            'url' => 'warehouse/issuerequisition/' . $this->id,
        ]);

        return $btnDetail;
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

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id');
    }

    public function items()
    {
        return $this->hasMany(IssueRequisitionItem::class, 'issue_requisition_id');
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
