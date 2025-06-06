<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DashboardHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'field_name',
        'old_value',
        'new_value',
        'updated_by'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}