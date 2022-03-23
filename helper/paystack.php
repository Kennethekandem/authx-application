<?php
/**
 * Created by IntelliJ IDEA.
 * User: samuelogu
 * Date: 10/11/2018
 * Time: 1:37 PM
 */

class paystack {

    public static function transferrecipient($data) {

        $request = self::curl('transferrecipient', 'post', $data);
        $respond = request::toArray($request);
        return $respond;

    }

    public static function transfer($data) {

        $request = self::curl('transfer', 'post', $data);
        $respond = request::toArray($request);
        return $respond;

    }

    public static function bank() {
        $request = self::curl('bank', 'get');
        $respond = json_decode($request, True)['data'];
        return $respond;
    }

    public static function verify_no($bank_code, $account_no) {

        $request = self::curl('bank/resolve?account_number='.$account_no.'&bank_code='.$bank_code, 'get');
        $respond = json_decode($request, True);
        return $respond;

    }

    public static function curl($url, $method, $data = array()) {

        $url = "https://api.paystack.co/".$url;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        if ($method == 'post') {
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS,json_encode($data));  //Post Fields
        }
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $headers = [
            'Authorization: Bearer '.config::paystack_sk(),
            'Content-Type: application/json',

        ];
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $request = curl_exec ($ch);

        curl_close ($ch);

        if ($request) {
            return $request;
        }

    }

}