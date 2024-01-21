<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdvertMedia extends Model
{
    use HasFactory;

    protected $fillable = [
        'media_name', 'is_active'
    ];

    // Advert Media can have many adverts
    public function adverts()
    {
        return $this->hasMany(Advert::class);
    }
}
