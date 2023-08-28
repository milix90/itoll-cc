<?php

namespace App\Http\Requests;

use App\Rules\EvaluateCourierRule;
use Illuminate\Foundation\Http\FormRequest;

class AvailableOrdersRequst extends FormRequest
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
            "client" => ["required", "array", new EvaluateCourierRule]
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
}
