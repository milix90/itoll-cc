<?php

namespace App\Rules;

use App\Constants\Hooks;
use App\Models\Order;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class EvaluateOrderRule implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $order = Order::query()->where("order_code", "=", $value);

        if (!$order->exists()) {
            $fail(__("custom.not_found", ["item" => "order"]));
            return;
        }

        if ($order->first()->status != Hooks::WAITING) {
            if ($order->first()->status == Hooks::REVOKED) {
                $fail(__("custom.invalid_order"));
                return;
            }

            $fail(__("custom.in_progress"));
        }
    }
}
