<?php
namespace App\Helpers;

use Kavenegar\Exceptions\ApiException;
use Kavenegar\Exceptions\HttpException;
use Kavenegar\KavenegarApi;

class NotificationMobile
{
    public static function SendSms($mobile, string $token_1, string $token_2, string $token_3, $template_name): bool
    {
        try {
            $api = new KavenegarApi(config('sms.API_SMS_KEY'));
            $receptor = $mobile;
            $token = $token_1;
            $token2 = $token_2;
            $token3 = $token_3;
            $template = $template_name;
            $type = "sms";//sms | call
            $result = $api->VerifyLookup($receptor, $token, $token2, $token3, $template, $type);
            if ($result) {
                return true;
            }
            else{
                return false;
            }
        } catch (ApiException|HttpException $e) {
            echo $e->errorMessage();
            return false;
        }
    }
}
