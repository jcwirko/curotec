<?php

namespace App\Http\Requests\Auth;

final class PasswordRule
{
    const PASSWORD = ["required", "string", "min:6", "max:250"];
}