<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quotation extends Model
{
    use HasFactory;

    protected $fillable = [
        'reference',
        'quotation_number',
        'customer_id',
        'address',
        'phone',
        'issue_date',
        'expire_date',
        'project_id',
        'salesman_id',
        'business_type',
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
        'created_at',
        'updated_at',
    ];

    public function getActiveStyleAttribute()
    {
        $isActive = view('components.index.table-status', [
            'role' => 'user',
            'url' => 'revenue/quotations/toggle_active/' . $this->id,
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
            'permissions' => ['*', 'all quotation', 'edit quotation'],
            'url' => 'revenue/quotations/' . $this->id . '/edit',
            'name' => $this->quotation_number,
        ]);

        return $btnEdit;
    }

    public function getBtnEditAttribute()
    {
        $btnEdit = view('components.index.table-edit', [
            'permissions' => ['*', 'all quotation', 'edit quotation'],
            'url' => 'revenue/quotations/' . $this->id . '/edit',
            'id' => $this->id,
        ]);

        return $btnEdit;
    }

    public function getBtnDeleteAttribute()
    {
        $btnDelete = view('components.index.table-delete', [
            'permissions' => ['*', 'all quotation', 'delete quotation'],
            'url' => 'revenue/quotations/' . $this->id,
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
            case 'await_accept':
                $class = 'primary';
                break;
            case 'expired':
                $class = 'danger';
                break;
            case 'accepted':
                $class = 'success';
                break;
            case 'voided':
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
        $progress = [1 => 'quotation', 2 => 'accepted', 3 => 'invoice', 4 => 'payment', 5 => 'receipt', 6 => 'tax_invoice'];
        $component = view('components.progress', [
            'progress' => $progress,
            'active' => array_search($this->progress ?? 'quotation', $progress),
            'file' => 'po',
        ]);

        return $component;
    }

    public function items()
    {
        return $this->hasMany(QuotationItem::class, 'quotation_id');
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
