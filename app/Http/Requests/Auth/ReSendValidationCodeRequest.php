<?php

namespace App\Http\Requests\Auth;

use App\Http\Requests\BaseRequest;
use App\Models\Entities\User;
use App\Models\Repositories\UserRepository;
use App\Models\Rules\ResendValidationCode;
use App\Models\Rules\VerifiedRegistrationValidationId;
use App\Models\Services\EncryptAndSignService;

class ReSendValidationCodeRequest extends BaseRequest
{
    public $errorBag = "resend-validation-code";

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            "validation_id" => ["required", 'string', 'bail']
        ];

        if (!is_null($this->validation_id) && is_string($this->validation_id)) {
            $userAgent = request()->header('user-agent');
            $ipAddress = request()->ip();
            $encryptService = new EncryptAndSignService();
            $userRepository = new UserRepository(new User());
    
            $rules['validation_id'][] = new VerifiedRegistrationValidationId($this->validation_id, $userAgent, $ipAddress, $encryptService, $userRepository);
            $rules['validation_id'][] = new ResendValidationCode($this->validation_id, $encryptService);
        }

        return $rules;
    }
}
