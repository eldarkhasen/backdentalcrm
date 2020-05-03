<?php

namespace App\Http\Requests;

use App\Exceptions\WebServiceException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

abstract class WebBaseRequest extends FormRequest
{

    public $data = [];

    public function authorize()
    {
        return true;
    }

    public abstract function injectedRules(): array;

    public function rules()
    {
        return $this->injectedRules();
    }

    protected function failedValidation(Validator $validator)
    {
        request()
            ->session()
            ->flash('error', trans('admin.error'));
        throw new WebServiceException($validator, request()->all());
    }

    public function addCellToDataArray($key, $value)
    {
        $this->data[$key] = $value;
    }

}
