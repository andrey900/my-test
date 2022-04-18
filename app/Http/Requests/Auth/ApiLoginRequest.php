<?php

namespace App\Http\Requests\Auth;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class ApiLoginRequest extends LoginRequest
{
    protected function failedValidation(Validator $validator)
    {
    }
}
