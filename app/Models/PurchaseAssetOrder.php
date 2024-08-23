<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseAssetOrder extends Model
{
    use HasFactory;
    protected $fillable = [
        'reference',
        'doc_number',
        'transaction_type',
        'seller_id',
        'address',
        'phone',
        'issue_date',
        'due_date',
        'post_date',
        'approved_date',
        'project_id',
        'vat_type',
        'currency_code',
        'is_discount',
        'discount_amt',
        'total_exm_amt',
        'total_zer_amt',
        'total_std_amt',
        'total_vat_amt',
        'total_wht_amt',
        'grand_total',
        'file',
        'remark',
        'status_code',
        'progress',
        'is_active',
        'company_id',
        'created_by',
        'updated_by',
    ];

    public function getActiveStyleAttribute()
    {
        $isActive = view('components.index.table-status', [
            'role' => 'user',
            'url' => 'purchase_ledger/purchase_asser_orders/toggle_active/' . $this->id,
            'data' => [
                'id' => $this->id,
                'isActive' => $this->is_active,
            ],
        ]);

        return $isActive;
    }

    public function getEditLinkAttribute()
    {
        $btnEdit = view('components.index.edit-link', [
            'permissions' => ['*', 'all po', 'edit po'],
            'url' => $this->status_code == 'draft'
                    ?'purchase_ledger/purchase_asser_orders/' . $this->id . '/edit'
                    :'purchase_ledger/purchase_asser_orders/' . $this->id,
            'name' => $this->doc_number,
        ]);

        return $btnEdit;
    }

    public function getBtnEditAttribute()
    {
        $btnEdit = view('components.index.table-edit', [
            'permissions' => ['*', 'all po', 'edit po'],
            'url' => 'purchase_ledger/purchase_asser_orders/' . $this->id . '/edit',
            'id' => $this->id,
        ]);

        return $btnEdit;
    }

    public function getBtnDeleteAttribute()
    {
        $btnDelete = view('components.index.table-delete', [
            'permissions' => ['*', 'all po', 'delete po'],
            'url' => 'purchase_ledger/purchase_asser_orders/' . $this->id,
        ]);

        return $btnDelete;
    }

    public function getBtnApproveAttribute()
    {
        $btnApprove = view('components.index.table-approve', [
            'permissions' => ['*', 'all po', 'approve po']            
        ]);

        return $btnApprove;
    }

    public function getStatusStyleAttribute()
    {
        $class = '';
        switch ($this->status_code) {
            case 'draft':
                $class = 'secondary';
                break;
            case 'await_approval':
                $class = 'warning';
                break;
            case 'approved':
                $class = 'success';
                break;
            case 'voided':
                $class = 'danger';
                break;
            default:
                $class = 'secondary';
                break;
        }
        return '<span><i class="fa-regular fa-circle-dot mr-1 text-'.$class.'"></i>' . $this->status_code . '</span>';
    }

    public function getProgressStyleAttribute()
    {
        $progress = [1 => 'pao', 2 => 'pi', 3 => 'pv'];
        $component = view('components.progress', [
            'progress' => $progress,
            'active' => array_search($this->progress??'po', $progress),
            'file' => 'purchase',
        ]);

        return $component;
    }

    public function getIsPaymentAttribute()
    {
        return false;
    }
}
