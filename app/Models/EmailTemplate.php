<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailTemplate extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'subject',
        'body',
        'description',
        'variables',
        'status',
    ];

    protected $casts = [
        'variables' => 'array',
    ];

    /**
     * Find a template by its unique name.
     *
     * @param string $name
     * @return self|null
     */
    public static function findByName(string $name): ?self
    {
        return static::where('name', $name)->first();
    }

    public function scopeSearch($query, $search)
    {
        return $query->where('name', 'LIKE', "%{$search}%")
            ->orWhere('subject', 'LIKE', "%{$search}%")
            ->orWhere('description', 'LIKE', "%{$search}%");
    }

    public function scopeStatus($query, $status)
    {
        return $status == 'ACTIVE' ? $query->where('status', true) : $query->where('status', false);
    }
}
