<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdvertViews extends Model
{
    use HasFactory;

    protected $table = "advertisers_viewed_ads";

    protected $fillable = [
        'advertiser_id', 'advert_id', 'user_id', 'viewed_at'
    ];

    public $timestamps = false;



}
