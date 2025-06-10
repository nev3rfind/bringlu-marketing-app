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
        'name',
        'email',
        'password',
        'account_type',
        'title',
        'other_title',
        'company_website'
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
     * Get the display name for the user
     */
    public function getDisplayNameAttribute()
    {
        return $this->name;
    }

    /**
     * Get the first name from the full name
     */
    public function getFirstNameAttribute()
    {
        return explode(' ', $this->name)[0];
    }

    /**
     * Get the last name from the full name
     */
    public function getLastNameAttribute()
    {
        $nameParts = explode(' ', $this->name);
        return count($nameParts) > 1 ? end($nameParts) : '';
    }

    /**
     * Get the title text with other title if applicable
     */
    public function getTitleTextAttribute()
    {
        if ($this->title === 'Other' && $this->other_title) {
            return $this->other_title;
        }
        return $this->title;
    }
}