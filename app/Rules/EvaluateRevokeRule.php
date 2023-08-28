<?php

namespace App\Rules;

use App\Constants\Hooks;
use App\Models\Order;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class EvaluateRevokeRule implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $order = Order::query()->where("order_code", "=", $value);

        if (!$order->exists()) {
            $fail(__("custom.not_found", ["item" => "order"]));
            return;
        }

        if (!in_array($order->first()->status, [Hooks::WAITING, Hooks::ACCEPTED, Hooks::LEAVING,])) {
            $fail(__("custom.revoke_restrict"));
        }
    }
}
