<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class PhoneOrEmail implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // PHONE validation when country code exists
        if (request()->filled('phone_country_code')) {

            if (! preg_match(config('validation.phone_number.regex'), $value)) {
                $fail('Phone number is invalid');
            }

            return;
        }

        // EMAIL validation when country code does NOT exist
        if (! filter_var($value, FILTER_VALIDATE_EMAIL)) {
            $fail('Email is invalid');
            return;
        }

        if (strlen($value) > config('validation.email.max')) {
            $fail(__('Max 255 characters'));
            return;
        }

        if (! preg_match(config('validation.email.regex'), $value)) {
            $fail(__('Email is invalid'));
        }
    }
}
