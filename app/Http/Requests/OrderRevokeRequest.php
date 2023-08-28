<?php

namespace App\Http\Requests;

use App\Rules\EvaluateCourierRule;
use App\Rules\EvaluateInvokererRule;
use App\Rules\EvaluateInvokerRule;
use App\Rules\EvaluateOrderRule;
use App\Rules\EvaluateRevokeRule;
use Illuminate\Foundation\Http\FormRequest;

class OrderRevokeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            "order_uuid" => ["required", "uuid", new EvaluateRevokeRule],
            "client" => ["required", "array", new EvaluateInvokerRule],
        ];
    }

    /**
     * @return void
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            "order_uuid" => request()->route()->parameter("uuid"),
            "client" => parse_token(request()),
        ]);
    }

    /**
     * @return void
     */
    protected function passedValidation(): void
    {
        $this->merge([
            "order_uuid" => request()->route()->parameter("uuid"),
            "client" => parse_token(request())["identity_code"],
        ]);
    }
}
