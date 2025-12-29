<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    protected $fillable = ['user_id', 'store_name', 'location'];

    public function vendor()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function scopeSearch($query, $term)
    {
        return $query->where(function ($q) use ($term) {
            $q->where('store_name', 'LIKE', "%{$term}%")
            ->orWhere('location', 'LIKE', "%{$term}%")
            ->orWhereHas('vendor', function ($vendorQuery) use ($term) {
                $vendorQuery->where('name', 'LIKE', "%{$term}%")
                            ->orWhere('email', 'LIKE', "%{$term}%");
            });
        });
    }
}
