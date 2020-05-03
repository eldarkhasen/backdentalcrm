<?php
/**
 * Created by PhpStorm.
 * User: air
 * Date: 12.01.2020
 * Time: 13:40
 */

namespace App\Core;


use App\Exceptions\ApiServiceException;
use App\Http\Errors\ErrorCode;

trait ErrorTrait
{

    public function throwError(\Exception $exception, $message = null)
    {
        throw new ApiServiceException(500, false, [
            'errors' => [
                $message ? $message : 'System error',
            ],
            'exception' => [
                'file' => $exception->getFile(),
                'message' => $exception->getMessage(),
                'line' => $exception->getLine(),
            ],
            'errorCode' => ErrorCode::SYSTEM_ERROR
        ]);
    }

}