<?php

namespace App\Traits;

use Carbon\Carbon;
use DateTimeInterface;

trait FormatsModelDates
{
    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->format(config('constant.date_format.php'));
    }

    public function getUpdatedAtAttribute($value)
    {
        return Carbon::parse($value)->format(config('constant.date_format.php'));
    }
}
