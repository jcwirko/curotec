<?php

namespace App\Http\Requests\Auth;

use App\Http\Requests\BaseRequest;
use App\Models\Entities\User;
use App\Models\Repositories\UserRepository;
use App\Models\Rules\VerifiedRegistrationValidationCode;
use App\Models\Rules\VerifiedRegistrationValidationId;
use App\Models\Services\EncryptAndSignService;

class RegisterRequest extends BaseRequest
{
    public $errorBag = "register";

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            "validation_code" => ["required", "digits:6", "bail"],
            "validation_id" => ["required", 'string']
        ];
        
        if (!is_null($this->validation_code) && is_numeric($this->validation_code) && !is_null($this->validation_id)) {
            $userAgent = request()->header('user-agent');
            $ipAddress = request()->ip();
            $encryptService = new EncryptAndSignService();
            $userRepository = new UserRepository(new User());
         
            $rules['validation_code'][] = new VerifiedRegistrationValidationId($this->validation_id, $userAgent, $ipAddress, $encryptService, $userRepository);
            $rules['validation_code'][] = new VerifiedRegistrationValidationCode($this->validation_code, $this->validation_id, $encryptService);
        }

        return $rules;
    }
}
