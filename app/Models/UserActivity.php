<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserActivity extends Model
{
    protected $fillable = ['user_id', 'activity', 'ip_address', 'user_agent', 'email', 'status'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeSearch($query, $term)
    {
       $query->where(function ($q) use ($term) {
        $q->whereHas('user', function ($userQuery) use ($term) {
            $userQuery->where('first_name', 'like', "%{$term}%")
                      ->orWhere('email', 'like', "%{$term}%");
        })
        ->orWhere('activity', 'like', "%{$term}%")
        ->orWhere('ip_address', 'like', "%{$term}%")
        ->orWhere('user_agent', 'like', "%{$term}%");
    });
    }
}
