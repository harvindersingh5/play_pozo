<?php
namespace App\Traits;

use App\Models\User;
use Exception;

trait UserTrait {
    /***
     * Return user by email or phone number 
     */
    public function getUserByEmailOrPhone(string $phone_email, ?string $phone_country_code = null) {
        try {
            if (empty($phone_country_code)) {
                $user = User::where('email', $phone_email)->first();
            } else {
                // Normalize phone and build E.164
                $phoneE164 = $phone_country_code . preg_replace('/\D/', '', $phone_email);

                $user = User::whereHas('user_detail', function ($q) use ($phoneE164) {
                    $q->where('phone_e164', $phoneE164);
                })->first();
            }
            return $user;
        } catch(Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
}