<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseInvoice extends Model
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
        'tax_expense_id',
        'vat_type',
        'currency_code',
        'tax_invoice_date',
        'tax_invoice_number',
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
            'url' => 'purchase_ledger/purchase_invoices/toggle_active/' . $this->id,
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
            'permissions' => ['*', 'all exprecord', 'edit exprecord'],
            'url' => $this->status_code == 'draft' 
                    ?'purchase_ledger/purchase_invoices/' . $this->id . '/edit'
                    :'purchase_ledger/purchase_invoices/' . $this->id,
            'name' => $this->doc_number,
        ]);

        return $btnEdit;
    }

    public function getBtnEditAttribute()
    {
        $btnEdit = view('components.index.table-edit', [
            'permissions' => ['*', 'all exprecord', 'edit exprecord'],
            'url' => 'purchase_ledger/purchase_invoices/' . $this->id . '/edit',
            'id' => $this->id,
        ]);

        return $btnEdit;
    }

    public function getBtnDeleteAttribute()
    {
        $btnDelete = view('components.index.table-delete', [
            'permissions' => ['*', 'all exprecord', 'delete exprecord'],
            'url' => 'purchase_ledger/purchase_invoices/' . $this->id,
        ]);

        return $btnDelete;
    }

    public function getBtnActionAttribute()
    {
        $btnAction = '';
        switch ($this->status_code) {
            case 'draft':
                $btnAction = view('components.index.table-approve', [
                    'permissions' => ['*', 'all exprecord', 'approve exprecord']
                ]);
                break;
            case 'outstanding':
            case 'overdue':
                $btnAction = view('components.index.table-paid', [
                    'permissions' => ['*', 'all exprecord', 'paid exprecord'],
                    'id' => $this->id,
                ]);
                break;
            default:
                break;
        }

        return $btnAction;
    }

    // 'draft','await_approval','outstanding','overdue','await_receipt','got_receipt','voided','recurring
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
            case 'outstanding':
                $class = 'primary';
                break;
            case 'overdue':
                $class = 'danger';
                break;
            case 'await_receipt':
                    $class = 'warning';
                    break;
            case 'got_receipt':
                $class = 'success';
                break;
            case 'voided':
                $class = 'danger';
                break;
            case 'recurring':
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
        $progress = [1 => 'pi', 2 => 'pv'];
        $component = view('components.progress', [
            'progress' => $progress,
            'active' => array_search($this->progress ?? 'exp', $progress),
            'file' => 'purchase',
        ]);

        return $component;
    }

    public function getIsPaymentAttribute()
    {
        return true;
    }
    
    
}
