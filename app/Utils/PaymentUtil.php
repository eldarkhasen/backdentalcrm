<?php


namespace App\Utils;


class PaymentUtil
{

    public const _3D_SECURE_URL = 'https://api.cloudpayments.ru/payments/cards/post3ds';
    public const _REFUND_URL = 'https://api.cloudpayments.ru/payments/refund';
    public const _TOKEN_CHARGE = 'https://api.cloudpayments.ru/payments/tokens/charge';
    public  const  _CARDS_CHARGE = 'https://api.cloudpayments.ru/payments/cards/charge';
    public const _REFUND_CONFIRM_URL = 'https://api.cloudpayments.ru/payments/confirm';
    public const _CLOUDPAYMENTS_USERNAME = 'pk_5ca541f82448e11afb98b5c1a3ffa';
    public const _CLOUDPAYMENTS_PASSWORD = 'cc06d6b7614d4834809dfdd755527f1a';


    public static function getUsername()
    {
        return self::_CLOUDPAYMENTS_USERNAME;
    }

    public static function getPassword()
    {
        return self::_CLOUDPAYMENTS_PASSWORD;
    }

    public static function getBase64EncodedAuthToken()
    {
        return base64_encode(self::getUsername() . ':' . self::getPassword());
    }
}
