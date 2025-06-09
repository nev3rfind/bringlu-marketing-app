<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReferralForm extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'referral_details',
        'theme_type',
        'other_theme',
        'purchase_email',
        'license_code',
        'shopify_store_url',
        'status',
        'viewed'
    ];

    protected $dates = [
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'viewed' => 'boolean'
    ];

    // A referral form belongs to a user (advertiser)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the theme type as a formatted string
     */
    public function getThemeTypeTextAttribute()
    {
        switch ($this->theme_type) {
            case 'minimog':
                return 'Minimog';
            case 'megamog':
                return 'Megamog';
            case 'other':
                return $this->other_theme ?: 'Other';
            default:
                return 'Not specified';
        }
    }
}