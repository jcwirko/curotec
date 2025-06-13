<?php

namespace App\Http\Requests\Auth;

use App\Http\Requests\BaseRequest;

class UpdatePasswordRequest extends BaseRequest
{
    public $errorBag = "update-password";

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            "password" => PasswordRule::PASSWORD,
            "token" => ['required', 'string']
        ];
    }
}
