<?php

/**
 * REQUEST CLASS
 */
class request {

    public static function secureTxt($txt) {
        $txt = htmlentities($txt);
        $txt = stripslashes($txt);
        return $txt;
    }

    public static function securePwd($pwd, $rounds = 9) {

    	$salt = "";
    	$saltChars = array_merge(range('A', 'Z'), range('a', 'z'), range(0, 9));
    	for ($i=0; $i < 22; $i++) {
    		$salt .= $saltChars[array_rand($saltChars)];
    	}
    	return crypt($pwd, sprintf('$2y$%02d$', $rounds) . $salt);

    }

    public static function hashString($string) {
        $string = sha1($string);
        $string = htmlentities($string);
        $string = stripslashes($string);
        return $string;
    }

    public static function trim($string) {
        return trim(preg_replace('/\s+/', ' ', $string));
    }

    public static function randomString() {
        $rand = rand(100000, 999999);
        return self::hashString($rand);
    }

    public static function slug($text) {
        // replace non letter or digits by -
      $text = preg_replace('~[^\pL\d]+~u', '-', $text);

      // transliterate
      $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

      // remove unwanted characters
      $text = preg_replace('~[^-\w]+~', '', $text);

      // trim
      $text = trim($text, '-');

      // remove duplicate -
      $text = preg_replace('~-+~', '-', $text);

      // lowercase
      $text = strtolower($text);

      if (empty($text)) {
        return 'n-a';
      }

      return $text;
    }

    public static function timeago($time_ago) {

        $cur_time   = time();
        $time_elapsed   = $cur_time - $time_ago;
        $seconds  = $time_elapsed ;
        $minutes  = round($time_elapsed / 60 );
        $hours    = round($time_elapsed / 3600);
        $days     = round($time_elapsed / 86400 );
        $weeks    = round($time_elapsed / 604800);
        $months   = round($time_elapsed / 2600640 );
        $years    = round($time_elapsed / 31207680 );
    // Seconds
        if($seconds <= 60){
            echo "$seconds seconds ago";
        }
    //Minutes
        else if($minutes <=60){
            if($minutes==1){
                echo "one minute ago";
            }
            else{
                echo "$minutes minutes ago";
            }
        }
    //Hours
        else if($hours <=24){
            if($hours==1){
                echo "an hour ago";
            }else{
                echo "$hours hours ago";
            }
        }
    //Days
        else if($days <= 7){
            if($days==1){
                echo "yesterday";
            }else{
                echo "$days days ago";
            }
        }
    //Weeks
        else if($weeks <= 4.3){
            if($weeks==1){
                echo "a week ago";
            }else{
                echo "$weeks weeks ago";
            }
        }
    //Months
        else if($months <=12){
            if($months==1){
                echo "a month ago";
            }else{
                echo "$months months ago";
            }
        }
    //Years
        else{
            if($years==1){
                echo "one year ago";
            }else{
                echo "$years years ago";
            }
        }

    }// TIME AGO METHOD

    public static function data() {
        $method = $GLOBALS['config']['request']['method'];
        $data = array();
        foreach ($GLOBALS['config']['request']['data'] as $key => $value) {
            $d = array($key => self::secureTxt($value));
            $data += $d;
        }
        $request = array("method" => $method, "request" => $data);
        return $request;
    }

    public static function parameters($data, $required) {

        $isOkay = true;
        foreach ($required as $key => $value) {

            if (!array_key_exists($value, $data)) {
                $isOkay = false;
            }
        }

        if ($isOkay) {
            return true;
        }else {

            return false;

        }

    }

    public static function compress($source, $destination, $quality = 40) {

		$info = getimagesize($source);

		if ($info['mime'] == 'image/jpeg')
			$image = imagecreatefromjpeg($source);

		elseif ($info['mime'] == 'image/gif')
			$image = imagecreatefromgif($source);

		elseif ($info['mime'] == 'image/png')
			$image = imagecreatefrompng($source);

		if (imagejpeg($image, $destination, $quality)) {
		    return true;
		}else {
            return false;
        }

	}

    public static function generateRandomID($length = 34) {
        $characters = '123456789abcdefghijklmnopqrstuvwxyz';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public static function toArray($json) {
        return json_decode(json_encode($json), true);
    }

    public static function toSatoshi($amount) {

        return number_format($amount, 8, '.', '');
    }

    public static function usdPrice() {
        $price = config::usd_btc();
        return $price;
    }

    public static function ngnToBtc($naira) {
        $usd = $naira / config::usd_ngn();
        return self::toSatoshi(self::toBtc($usd));
    }

    public static function transaction_fee($amount) {
        $url = 'https://bitcoinfees.earn.com/api/v1/fees/recommended';
        $respond = file_get_contents($url);
        $price = intval(json_decode($respond, True)['halfHourFee']) / intval(100000000);
        $fee = number_format($price, 8);
        return $fee;
    }

    public static function toBtc($usd) {
        $price = $usd / config::usd_btc();

    return $price;
    }

    public static function toNGN($btc) {
        $usd = $btc * self::usdPrice();
        $price = config::usd_ngn();
        return $usd * $price;
    }

    public static function USDtoNGN($type = null) {
        return config::usd_ngn();
    }

    public static function validate($address) {
        global $block_io;

        $status = request::toArray($block_io->is_valid_address(array('address' => $address)))['data']['is_valid'];
        return $status;

    }

    public static function pre($object) {
        ?>
<pre><?php print_r($object); ?></pre>
<?php
    }

//    public static function get_network_fee_estimate($amount, $address) {
//        global $block_io;
//        $block_io->get_network_fee_estimate(array('amounts' => $amount, 'to_addresses' => '32XN3LiYPkyP8cdGvf8kb26YG57MreQBrW'))
//    }


}

