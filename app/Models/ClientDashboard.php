<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientDashboard extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'earnings',
        'profit',
        'revenue',
        'pay_date',
        'total',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}