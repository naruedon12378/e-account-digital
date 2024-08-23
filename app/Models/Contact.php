<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Contact extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'party_type',
        'region',
        'tax_id',
        'branch',
        'business_type',
        'sub_business_type_id',
        'prefix',
        'first_name',
        'last_name',
        'company_name',
        'email',
        'phone',
        'website',
        'fax',
        'sale_credit_term_id',
        'purchase_credit_term_id',
        'sale_account_id',
        'purchase_account_id',
        'credit_limit_type',
        'credit_limit_amt',
        'company_id',
        'created_by',
        'updated_by',
    ];

    public function scopeActive($query)
    {
        return $query->where([
                ['company_id', Auth::user()->company_id],
                ['is_active', true]
            ]);
    }

    public function getActiveStyleAttribute()
    {
        $isActive = view('components.index.table-status',[
                        'role' => 'user',
                        'url' => 'contacts/toggle_active/'.$this->id,
                        'data' => [
                            'id' => $this->id,
                            'isActive' => $this->is_active,
                        ],
                    ]);

        return $isActive;
    }

    public function getShowLinkAttribute()
    {
        $btnEdit = view('components.index.edit-link', [
            'permissions' => ['*', 'all contact', 'edit contact'],
            'url' => 'contacts/' . $this->id,
            'name' => $this->code,
        ]);

        return $btnEdit;
    }

    public function getBtnEditAttribute()
    {
        $btnEdit = view('components.index.table-edit',[
                        'permissions' => ['*', 'all contact', 'edit contact'],
                        'url' => 'contacts/'.$this->id.'/edit',
                        'id' => $this->id,
                    ]);

        return $btnEdit;
    }

    public function getBtnDeleteAttribute()
    {
        $btnDelete = view('components.index.table-delete',[
                            'permissions' => ['*', 'all contact', 'delete contact'],
                            'url' => 'contacts/'.$this->id,
                        ]);

        return $btnDelete;
    }

    public function getPartyNameAttribute()
    {
        if ($this->business_type == 'P')
            return $this->first_name.' '.$this->last_name;
        
        return $this->company_name;
    }

    public function bank(){
        return $this->belongsTo(ContactBank::class, 'contact_id');
    }

    public function person(){
        return $this->belongsTo(ContactPerson::class, 'contact_id');
    }

    public function office(){
        return $this->hasOne(OfficeAddress::class, 'contact_id');
    }

    public function registration(){
        return $this->belongsTo(RegisteredAddress::class, 'contact_id');
    }

}
