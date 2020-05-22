<?php
/**
 * Created by PhpStorm.
 * User: air
 * Date: 22.05.2020
 * Time: 23:44
 */

namespace App\Http\Requests\Web;


use App\Http\Requests\WebBaseRequest;

class ConfigWebRequest extends WebBaseRequest
{
    public function injectedRules(): array
    {
        return [
            'token' => ['required'],
            'command' => ['required']
        ];
    }
}