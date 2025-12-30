<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Traits\FormatsModelDates;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles, SoftDeletes, HasApiTokens, FormatsModelDates;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'email_verified_at',
        'password',
        'encrypt_password',
        'status',
        'otp_code',
        'otp_expires_at',
    ];
    protected $dates = ['deleted_at'];


    protected $appends = ['full_name', 'role'];


    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }


    public function getFullNameAttribute(): string
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function user_detail()
    {
        return $this->hasOne(UserDetail::class);
    }

    public function scopeExcludeAdmins($query)
    {
        return $query->whereDoesntHave('roles', function ($q) {
            $q->where('name', 'Administrator');
        });
    }

    public function scopeExcludeSubAdmins($query)
    {
        return $query->whereDoesntHave('roles', function ($q) {
            $q->whereIn('name', ['Administrator', 'SubAdmin']);
        });
    }

    // Scope to filter users by search term
    public function scopeSearch($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('first_name', 'like', '%' . $search . '%')
                ->orWhere('email', 'like', '%' . $search . '%');
        });
    }

    // Scope to filter users by status
    public function scopeStatus($query, $status)
    {
        if ($status !== 'All') {
            return $query->where('status', $status);
        }
        return $query;
    }

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($user) {
            $user->user_detail()->delete();
        });

        static::restoring(function ($user) {
            $user->user_detail()->restore();
        });
    }

    public function getProfileUrlAttribute(): ?string
    {
        $userDetail = $this->user_detail;

        if ($userDetail?->profile_path) {
            return Storage::url($userDetail->profile_path);
        }

        return asset('assets/custom/images/default-profile.png');
    }

    public function getBackgroundUrlAttribute(): ?string
    {
        $userDetail = $this->user_detail;

        if ($userDetail?->back_profile_path) {
            return Storage::url($userDetail->back_profile_path);
        }

        return asset('assets/custom/images/default-background-image.webp');
    }

    public function thumbnails(): MorphMany
    {
        return $this->morphMany(Thumbnail::class, 'imageable');
    }

    /**
     * Get the stores associated with the user.
     */
    public function stores()
    {
        return $this->hasMany(Store::class);
    }


    /**
     * Get role of user
     */
    public function getRoleAttribute() {
        return $this->getRoleNames()->toArray();
    }

}
