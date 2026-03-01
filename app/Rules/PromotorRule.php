<?php

namespace App\Rules;

use App\Models\Dosen;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class PromotorRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $values = explode(',', $value);
        if (count($values) < 2) {
            $fail('Usulan promotor harus berisi minimal 2 promotor.');
        } else if (count($values) > 3) {
            $fail('Usulan promotor tidak boleh lebih dari 3 promotor.');
        }

        foreach ($values as $promotor) {
            // check if promotor is valid
            $dosen = Dosen::where('id', $promotor)->first();
            if (!$dosen) {
                $fail('Promotor tidak valid.');
            }
        }
    }
}
