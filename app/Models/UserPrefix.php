<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class UserPrefix extends Model
{
    use HasFactory, Sluggable;

    protected $table = 'prefixes';

    protected $fillable = [
        'name_th',
        'name_en',
        'slug',
    ];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name_th'
            ]
        ];
    }

    public function getRouteKeyName(){
        return 'slug';
    }

    public function user(){
        return $this->hasMany(User::class);
    }
}