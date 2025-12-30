<?php
namespace App\Traits;

trait CustomRequestFunction {
    /***
     * set phone_code and number into a single field
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'phone_e164' => $this->phone_country_code . $this->phone_number,
        ]);
    }
}
