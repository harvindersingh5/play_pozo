<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = ['key', 'value'];
    
    protected $casts = [
        'value' => 'array',
    ];
    
    /**
     * Get a setting by key
     */
    public static function getSetting($key, $default = null)
    {
        $setting = self::where('key', $key)->first();
        
        return $setting ? $setting->value : $default;
    }
    
    /**
     * Set a setting by key
     */
    public static function setSetting($key, $value)
    {
        $value = trim($value, '"');
        return self::updateOrCreate(
            ['key' => $key],
            ['value' => $value]
        );

    }
}
