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

    // A dashboard card can have many values (including history)
    public function values()
    {
        return $this->hasMany(DashboardCardValue::class);
    }

    // Get current active value for specific user
    public function getActiveValueForUser($userId)
    {
        return $this->values()
            ->where('user_id', $userId)
            ->where('is_active', true)
            ->first();
    }

    // Get all history values for specific user (inactive values)
    public function getHistoryForUser($userId)
    {
        return $this->values()
            ->where('user_id', $userId)
            ->where('is_active', false)
            ->orderBy('created_at', 'desc')
            ->get();
    }
}