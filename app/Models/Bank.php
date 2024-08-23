<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Bank extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;
    protected $table = 'banks';
    protected $fillable = [
        'name_th',
        'name_en',
        'sort',
        'publish',
    ];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('bank');
    }
}