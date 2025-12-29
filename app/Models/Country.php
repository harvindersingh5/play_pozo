<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    public function getNameAttribute($value)
    {
        return ucfirst($value);
    }
}
