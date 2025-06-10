<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReferralForm extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'theme_type',
        'purchase_email',
        'license_code',
        'shopify_store_url',
        'proof_file_path',
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
            case 'zest':
                return 'Zest';
            case 'sleek':
                return 'Sleek';
            case 'hyper':
                return 'Hyper';
            default:
                return 'Not specified';
        }
    }
}