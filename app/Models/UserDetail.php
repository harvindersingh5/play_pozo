<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserDetail extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $fillable = ['user_id','address','profile_path','country','state','city','phone_number','pincode','back_profile_path','gender', 'phone_e164', 'phone_country_code'];

    protected $appends = [
        'country_name',
        'state_name',
        'city_name',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function getPublicUrlAttribute()
    {
        $value = $this->profile_path;
        if (filter_var($value, FILTER_VALIDATE_URL)) {
            return $value;
        }
        if ($value && Storage::exists($value)) {
            return Storage::url($value);
        }else{
            return null;
        }

    }

    public function getBackgroundUrlAttribute()
    {
        $value = $this->back_profile_path;
        if (filter_var($value, FILTER_VALIDATE_URL)) {
            return $value;
        }
        if ($value && Storage::exists($value)) {
            return Storage::url($value);
        }else{
            return null;
        }

    }

    public function countryData()
    {
        return $this->belongsTo(Country::class, 'country', 'id');
    }
    public function stateData()
    {
        return $this->belongsTo(State::class, 'state', 'id');
    }
    public function cityData()
    {
        return $this->belongsTo(City::class, 'city', 'id');
    }

    public function getCountryNameAttribute()
    {
        return $this->countryData ? $this->countryData->name : null;
    }

    public function getStateNameAttribute()
    {
        return $this->stateData ? $this->stateData->name : null;
    }

    public function getCityNameAttribute()
    {
        return $this->cityData ? $this->cityData->name : null;
    }
}
