<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DashboardCardValue extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'dashboard_card_id',
        'value'
    ];

    // A dashboard card value belongs to a user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // A dashboard card value belongs to a dashboard card
    public function dashboardCard()
    {
        return $this->belongsTo(DashboardCard::class);
    }
}