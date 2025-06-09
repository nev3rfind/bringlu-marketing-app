<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Advert;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'phone',
        'account_type',
        'email',
        'password',
        'account_type',
        'created_date',
        'title',
        'company_name',
        'company_website',
        'paypal_email',
        'commission_structure',
        'other_title'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'created_date' => 'datetime',
        'commission_structure' => 'array',
    ];

    // User can have many adverts
    public function adverts() {
        return $this->hasMany(Advert::class);
    }

    // User (advert creator) is linked with advert status
    public function advertStatus() {
        return $this->belongsTo(AdvertStatus::class);
      }

    /**
     * Get the commission structure themes as a formatted string
     */
    public function getCommissionStructureTextAttribute()
    {
        if (!$this->commission_structure) {
            return 'None selected';
        }
        
        $themes = [];
        foreach ($this->commission_structure as $theme) {
            $themes[] = ucfirst($theme) . ' Theme';
        }
        
        return implode(', ', $themes);
    }
}