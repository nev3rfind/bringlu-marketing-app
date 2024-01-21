<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdvertStatus extends Model
{
    use HasFactory;

    protected $table = "advertisers_ads_status";

    protected $fillable = [
        'advertiser_id', 'advert_id', 'user_id', 'advert_status',
        'extra_details', 'last_actioned_at'
    ];

    public $timestamps = false;

    // One link of advert status (request) can have only one advert submitted
    public function advert()
    {
        return $this->hasOne(Advert::class, 'id', 'advert_id');
    }

    // One link of advert status (request) can have only one advertiser (person who submitted advert)
    public function advertiser()
    {
        return $this->hasOne(User::class, 'id', 'advertiser_id');
    }
}
