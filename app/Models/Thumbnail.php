<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Thumbnail extends Model
{
    protected $fillable = ['url', 'name', 'imageable_id', 'imageable_type', 'extension'];

    public function imageable(): MorphTo
    {
        return $this->morphTo();
    }
}
