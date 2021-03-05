<?php
/**
 * Created by PhpStorm.
 * Filename: GGCapcha.php
 * User: Thang Nguyen Nhan
 * Date: 12/21/2018
 * Time: 14:19
 */

namespace App\Helpers;


class GGCapcha
{
    private static $instance;
    protected $URL = 'https://www.google.com/recaptcha/api/siteverify';
    public static $SITE_KEY = '6LfaWxkUAAAAAPB8PuHxTjenNiEqv_jYg6KuzRDy';
    public static $SECRET_KEY = '6LfaWxkUAAAAAAEM2DqxHYRRg1s3ZuMwfZUhKgSd';

    public static function getInstance() {
        if (self::$instance == null) {
            self::$instance = new GGCapcha();
        }
        return self::$instance;
    }

    public function verifyv2($g_capcha_res,$ip = '') {
        ob_start();

        $post_fields['secret'] = self::$SECRET_KEY;
        $post_fields['response'] = $g_capcha_res;
//        $post_fields['remoteip'] = $ip;

        $curl_handle = curl_init('https://www.google.com/recaptcha/api/siteverify');

        curl_setopt($curl_handle, CURLOPT_HEADER, 0);
        curl_setopt($curl_handle, CURLOPT_VERBOSE, 0);
        curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl_handle, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible;)");
        curl_setopt($curl_handle, CURLOPT_POST, true);
        curl_setopt($curl_handle, CURLOPT_POSTFIELDS, $post_fields);
        curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);

        $returned_data = curl_exec($curl_handle);

        ob_end_clean();

        // close client URL
        curl_close ($curl_handle);

        $json_parse = json_decode($returned_data);
        if($json_parse && isset($json_parse->success) && $json_parse->success){
            return true;
        }
        return false;
    }
}