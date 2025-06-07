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
        'status',
        'viewed'
    ];

    protected $dates = [
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'viewed' => 'boolean',
        'expected_revenue' => 'decimal:2'
    ];

    // A referral form belongs to a user (advertiser)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}