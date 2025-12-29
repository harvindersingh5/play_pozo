<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Crypt;

class PaymentSetting extends Model
{
     use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'secret_key',
        'public_key',
        "account_holder_name",
        "account_holder_dob",
        "business_type",
        "account_type",
        "account_number",
        "routing_number",
        "currency",
        "country",
        "is_verified",
        "transfer_to",
        "stripe_btok_token",
        "stripe_ba_token",
        "stripe_account_token",
        "stripe_btok_token_response",
        "stripe_account_token_response",
        'paypal_client_id',
        'paypal_client_secret',
        'paypal_mode',
        'is_stripe_active',
        'is_paypal_active',
    ];

    // protected $appends = ['descryptPublicKey', 'descryptSecretKey'];

    /**
     * Interact with the user's secret key.
     *
     * @return  \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function secretKey(): Attribute
    {
        return Attribute::make(
            get: function($value) {
                if (!is_null($value)) {
                    $originalKey = Crypt::decrypt($value);
                    $visibleCount = 5;
                    $hiddenCount = 8;

                    $hiddenKey = substr($originalKey, 0, $visibleCount) . str_repeat('*', $hiddenCount) . substr($originalKey, ($visibleCount * -1), $visibleCount);

                    return [
                        'hidden' => $hiddenKey,
                        'original' => $originalKey
                    ];
                }

                return [
                    'hidden' => 'N/A',
                    'original' => ''
                ];
            },
            set: fn ($value) => Crypt::encrypt($value),
        );
    }

    /**
     * Interact with the user's public key.
     *
     * @return  \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function publicKey(): Attribute
    {
        return Attribute::make(
            get: function($value) {
                if (!is_null($value)) {
                    $originalKey = Crypt::decrypt($value);
                    $visibleCount = 5;
                    $hiddenCount = 8;

                    $hiddenKey = substr($originalKey, 0, $visibleCount) . str_repeat('*', $hiddenCount) . substr($originalKey, ($visibleCount * -1), $visibleCount);

                    return [
                        'hidden' => $hiddenKey,
                        'original' => $originalKey
                    ];
                }

                return [
                    'hidden' => 'N/A',
                    'original' => ''
                ];
            },
            set: fn ($value) => Crypt::encrypt($value),
        );
    }

    /**
     * set and get business type as per database
     */
    public function businessType(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => strtolower($value),
            set: fn ($value) => strtoupper($value),
        );
    }

    /**
     * set and get account type as per database
     */
    public function accountType(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => strtolower($value),
            set: fn ($value) => strtoupper($value),
        );
    }


    protected function paypalClientId(): Attribute
    {
        return Attribute::make(
            get: function($value) {
                if (!is_null($value)) {
                    $originalKey = Crypt::decrypt($value);
                    $visibleCount = 5;
                    $hiddenCount = 8;

                    $hiddenKey = substr($originalKey, 0, $visibleCount) . str_repeat('*', $hiddenCount) . substr($originalKey, ($visibleCount * -1), $visibleCount);

                    return [
                        'hidden' => $hiddenKey,
                        'original' => $originalKey
                    ];
                }

                return [
                    'hidden' => 'N/A',
                    'original' => ''
                ];
            },
            set: fn ($value) => Crypt::encrypt($value),
        );
    }

    protected function paypalClientSecret(): Attribute
    {
        return Attribute::make(
            get: function($value) {
                if (!is_null($value)) {
                    $originalKey = Crypt::decrypt($value);
                    $visibleCount = 5;
                    $hiddenCount = 8;

                    $hiddenKey = substr($originalKey, 0, $visibleCount) . str_repeat('*', $hiddenCount) . substr($originalKey, ($visibleCount * -1), $visibleCount);

                    return [
                        'hidden' => $hiddenKey,
                        'original' => $originalKey
                    ];
                }

                return [
                    'hidden' => 'N/A',
                    'original' => ''
                ];
            },
            set: fn ($value) => Crypt::encrypt($value),
        );
    }
}
