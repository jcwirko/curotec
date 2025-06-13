<?php

namespace App\Http\Requests\Auth;

use App\Http\Requests\BaseRequest;

class SendResetPasswordCodeRequest extends BaseRequest
{
    public $errorBag = "reset-password";

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            "email" => ["required", "string", "email", "exists:users,email"],
        ];
    }
}
