<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DashboardCardHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'dashboard_card_id',
        'old_value',
        'new_value',
        'changed_at'
    ];

    protected $dates = [
        'changed_at'
    ];

    // A dashboard card history belongs to a user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // A dashboard card history belongs to a dashboard card
    public function dashboardCard()
    {
        return $this->belongsTo(DashboardCard::class);
    }
}