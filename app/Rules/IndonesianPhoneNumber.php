<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class IndonesianPhoneNumber implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!preg_match('/^(62|0)8[0-9]{8,12}$/', $value)) {
            $fail('Format nomor telepon tidak valid. Nomor telepon harus diawali 62 atau 0 serta memiliki panjang 10-13 karakter.');
        }
    }
}
