<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\AdvertCategory;
use App\Models\AdvertMedia;
use App\Models\AdvertStatus;

class Advert extends Model
{
    use HasFactory;

    protected $fillable = [
    'user_id',
    'advert_category_id',
    'advert_media_id',
    'advert_name',
    'industry',
    'start_date',
    'end_date',
    'description',
    'current_status',
    'priority_level',
    'comments',
    'creator_ip_address',
    'web_url',
    'max_advertisers_count'
   ];

  protected $dates = [
    'created_at','updated_at'
  ];

  // Advert belongs to the user
  public function user() {
    return $this->belongsTo(User::class);
  }

  // Advert belongs to the advert category (foreign key in 'advert_categories' table)
  public function advertCategories() {
    return $this->belongsTo(AdvertCategory::class, 'advert_category_id');
  }

  // Advert belongs to the advert media type  (foreign key in 'advert_media' table)
  public function advertMedias() {
    return $this->belongsTo(AdvertMedia::class, 'advert_media_id');
  }

  // Same advert can have many different status if submitted by the different advertiser
  public function advertStatus() {
    return $this->belongsTo(AdvertStatus::class);
  }
}
