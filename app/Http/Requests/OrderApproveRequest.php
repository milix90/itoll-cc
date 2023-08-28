<?php

namespace App\Http\Requests;

use App\Rules\EvaluateCourierRule;
use App\Rules\EvaluateOrderRule;
use Illuminate\Foundation\Http\FormRequest;

class OrderApproveRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array[]
     */
    public function rules(): array
    {
        return [
            "order_uuid" => ["required", "uuid", new EvaluateOrderRule],
            "client" => ["required", "array", new EvaluateCourierRule],
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
