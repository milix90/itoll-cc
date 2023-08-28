<?php

namespace App\Rules;

use App\Constants\Revokers;
use App\Models\Courier;
use App\Models\Invoker;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class EvaluateInvokerRule implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if ($value["client"] !== Revokers::INVOKER) {
            $fail(__("custom.forbidden"));
            return;
        }

        $client = Invoker::query()
            ->where("identity_code", "=", $value["identity_code"]);

        if (!$client->exists()) {
            $fail(__("custom.not_found", ["item" => "client"]));
            return;
        }

        if (!$client->first()->active) {
            $fail(__("custom.deactivate", ["item" => "client"]));
        }
    }
}
