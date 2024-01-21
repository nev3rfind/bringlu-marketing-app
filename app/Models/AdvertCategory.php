<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Advert;

class AdvertCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_name', 'is_active'
    ];

    // Advert category can have many adverts
    public function adverts()
    {
        return $this->hasMany(Advert::class);
    }
}
