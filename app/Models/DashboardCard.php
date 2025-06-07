<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DashboardCard extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'position',
        'is_active'
    ];

    // A dashboard card can have many values (one per user)
    public function values()
    {
        return $this->hasMany(DashboardCardValue::class);
    }

    // A dashboard card can have many history entries
    public function history()
    {
        return $this->hasMany(DashboardCardHistory::class);
    }

    // Get value for specific user
    public function getValueForUser($userId)
    {
        return $this->values()->where('user_id', $userId)->first();
    }
}