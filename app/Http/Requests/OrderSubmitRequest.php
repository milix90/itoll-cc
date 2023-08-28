<?php

namespace App\Http\Requests;

use App\Rules\EvaluateInvokerRule;
use App\Rules\LatLongRule;
use Illuminate\Foundation\Http\FormRequest;

class OrderSubmitRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }


    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            "client" => ["required", "array", new EvaluateInvokerRule],
            'origin' => ['required', 'string', new LatLongRule],
            'origin_address' => ['required', 'string'],
            'client_name' => ['required', 'string'],
            'client_mobile' => ['required', 'numeric', 'regex:/^09\d{9}$/'],
            'destination' => ['required', 'string', new LatLongRule],
            'destination_address' => ['required', 'string'],
            'receiver_name' => ['required', 'string'],
            'receiver_mobile' => ['required', 'numeric', 'regex:/^09\d{9}$/'],
        ];
    }


    /**
     * @return void
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            "client" => parse_token(request()),
        ]);
    }

    /**
     * @return void
     */
    protected function passedValidation(): void
    {
        $this->merge([
            "client" => parse_token(request())["identity_code"],
        ]);
    }
}
