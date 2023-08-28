<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class LatLongRule implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!str_contains($value, ",")) {
            $fail("the Lat/Long is invalid/malformed.");
            return;
        }

        $location = explode(",", $value);

        foreach ($location as $index => $latLong) {
            if (!preg_match('/^-?([1-8]?[1-9]|[1-9]0)\.{1}\d{1,6}$/', $latLong)) {
                $fail("invalid Lat/Long format.");
                return;
            }
        }
    }
}
