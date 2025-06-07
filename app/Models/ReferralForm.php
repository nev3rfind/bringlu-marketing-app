<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReferralForm extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'referral_name',
        'company',
        'address',
        'template',
        'expected_revenue',
        'status'
    ];

    protected $dates = [
        'created_at',
        'updated_at'
    ];

    // A referral form belongs to a user (advertiser)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}