<?php


namespace App\Http\Requests\Api\V1\Appointments;


use App\Http\Requests\ApiBaseRequest;

class StoreTreatmentTypeListApiRequest extends ApiBaseRequest
{
    public function messages()
    {
        return [
            'template_id.required' => 'Введите ID шаблона',
            'types.required' => 'Заполните вопросы',
            'types.*.name.required' => 'Введите название вопроса',
            'types.*.options.*.value.required' => 'Введите опции',
        ];
    }

    public function injectedRules()
    {
        return [
            'template_id' => 'required',
            'types' => 'array|required',
            'types.*.name' => 'required',
            'types.*.options' => 'array',
            'types.*.options.*.value' =>'required',
        ];
    }
}
