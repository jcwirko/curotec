<?php

namespace App\Http\Requests\Auth;

use App\Http\Requests\BaseRequest;

class SendEmailValidationCodeRequest extends BaseRequest
{
    public $errorBag = "validate-email";

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            "first_name" => ["required", "string", "max:250"],
            "last_name" => ["required", "string", "max:250"],
            "email" => ["required", "string", "email", "unique:users,email", "max:250"],
            "password" => PasswordRule::PASSWORD,
            "terms_and_conditions" => ["required", "boolean", "accepted"]
        ];
    }
}
