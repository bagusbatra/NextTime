<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactMessage extends Model
{
    protected $fillable = [
        'name',
        'email',
        'phone',
        'service_interest',
        'message',
        'status',
    ];

    public function scopeStatus($query, string $status)
    {
        return $query->where('status', $status);
    }
}
