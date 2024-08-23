<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'reference',
        'doc_number',
        'customer_id',
        'address',
        'phone',
        'issue_date',
        'due_date',
        'post_date',
        'approved_date',
        'project_id',
        'salesman_id',
        'business_type',
        'vat_type',
        'issue_tax_invoice',
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
            'url' => 'revenue/invoices/toggle_active/' . $this->id,
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
            'permissions' => ['*', 'all invoice', 'edit invoice'],
            'url' => 'revenue/invoices/' . $this->id . '/edit',
            'id' => $this->id,
        ]);

        return $btnEdit;
    }

    public function getBtnDeleteAttribute()
    {
        $btnDelete = view('components.index.table-delete', [
            'permissions' => ['*', 'all invoice', 'delete invoice'],
            'url' => 'revenue/invoices/' . $this->id,
        ]);

        return $btnDelete;
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
            case 'outstanding':
                $class = 'primary';
                break;
            case 'overdue':
                $class = 'danger';
                break;
            case 'paid':
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
        return '<span class="badge badge-' . $class . ' p-2">' . $this->status_code . '</span>';
    }

    public function getProgressStyleAttribute()
    {
        $progress = [1 => 'invoice', 2 => 'payment', 3 => 'receipt', 4 => 'tax_invoice'];
        $component = view('components.progress', [
            'progress' => $progress,
            'active' => array_search($this->progress??'invoice', $progress),
            'file' => 'invoice',
        ]);

        return $component;
    }
}
