<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Image;

class SettingPayment extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;
    protected $table = 'setting_payments';
    protected $fillable = [
        'account_number',
        'remark',
        'advance_type',
        'account_type',
        'payment_option_one_id',
        'payment_option_two_id',
        'payment_option_three_id',
        'bank_id',
        'company_id',
        'payment_button_publish',
        'payment_type',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('payment_channel');
    }
}
