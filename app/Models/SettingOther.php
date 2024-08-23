<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SettingOther extends Model
{
    use HasFactory;
    protected $table = 'setting_others';
    protected $fillable = [
        'status_signature',
        'status_company_seal',
        'status_doc_access_code',
        'status_issue_invoice',
        'status_issue_receipt',
        'status_tax_invoice_no_vat',
        'status_pp_30_not_tax_invoice',
        'status_pp_30_sale_submit',
        'status_link_document',
        'company_id',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
