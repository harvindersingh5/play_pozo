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
                $fail(__('validation.custom.phone_number.regex'));
            }

            return;
        }

        // EMAIL validation when country code does NOT exist
        if (! filter_var($value, FILTER_VALIDATE_EMAIL)) {
            $fail(__('validation.custom.email.regex'));
            return;
        }

        if (! preg_match(config('validation.email.regex'), $value)) {
            $fail(__('validation.custom.email.regex'));
        }
    }
}
