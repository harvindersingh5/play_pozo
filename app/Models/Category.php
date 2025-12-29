<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Category extends Model
{
    protected $fillable = [
        'name',
        'status',
        'parent_id',
        'cat_img_path',
    ];

    public function parent()
    {
        return $this->belongsTo(Category::class);
    }

    public function scopeSearch($query, $search)
    {
        return $query->where('name', 'LIKE', "%{$search}%");
    }

    public function scopeStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    public function getCategoryImageUrlAttribute(): ?string
    {
        $categoryImage = $this->cat_img_path;

        if ($categoryImage) {
            return Storage::url($categoryImage);
        }

        return asset('assets/custom/images/default-category-image.webp');
    }


    public function thumbnails(): MorphMany
    {
        return $this->morphMany(Thumbnail::class, 'imageable');
    }
}
