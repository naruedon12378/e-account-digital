<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Branch extends Model
{
    use HasFactory;
    protected $table = 'branches';
    protected $primaryKey = 'id';
    protected $guarded = ['id'];
    protected $fillable = [
        'code',
        'name',
        'description',
        'address',
        'telephone',
        'fax',
        'email',
        'website',
        'created_by',
        'updated_by',
        'publish',
        'company_id',
        'user_creator_id',
        'user_checker_id',
        'user_approver_id',
    ];

    public function scopeMyCompany($query)
    {
        return $query->where('company_id', Auth::user()->company_id);
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
}
