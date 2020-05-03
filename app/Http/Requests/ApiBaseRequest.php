<?php

namespace App\Http\Requests\Api;


use App\Core\interfaces\WithUser;
use App\Exceptions\ApiServiceException;
use App\Http\Errors\ErrorCode;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

abstract class ApiBaseRequest extends FormRequest implements WithUser
{
    public function authorize()
    {
        return true;
    }

    public function getCurrentUser()
    {
        return Auth::user();
    }

    public function getCurrentUserId()
    {
        return Auth::id();
    }

    public abstract function injectedRules();

    public function rules()
    {
        return $this->injectedRules();
    }

    protected function failedValidation(Validator $validator)
    {
        throw new ApiServiceException(400, false, [
            'errorCode' => ErrorCode::INVALID_FIELD,
            'errors' => $validator->errors()
        ]);
    }
}
