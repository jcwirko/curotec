<?php

namespace App\Http\Requests\Auth;

use App\Http\Requests\BaseRequest;

class ValidateJWTExpRequest extends BaseRequest
{
    public $errorBag = "validate-jwt-exp";

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            "validation_id" => ['required', 'string'],
        ];
    }
}
