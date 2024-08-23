<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Cviebrock\EloquentSluggable\Sluggable;

class User extends Authenticatable implements HasMedia
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles, InteractsWithMedia, Sluggable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'slug',
        'user_code',
        'firstname',
        'lastname',
        'phone',
        'company_id',
        'status',
        'email',
        'password',
    ];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'user_code'
            ]
        ];
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function adminlte_profile_url()
    {
        return 'user';
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('user');
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function activestatus()
    {
        return $this->status == 1;
    }

    public function prefix()
    {
        return $this->belongsTo(UserPrefix::class);
    }

    public function address()
    {
        return $this->hasOne(UserAddress::class);
    }

    public function questionnaire()
    {
        return $this->hasOne(UserQuestionnarie::class);
    }

    public function assets()
    {
        return $this->hasMany(Asset::class);
    }
}
