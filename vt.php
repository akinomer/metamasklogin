<?php ob_start();
session_start();

//error_reporting(0);

define('INC', true);

require_once("include/database.php");

require_once("include/class.upload.php");



function isMobileDevice() {

    return preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]);

}

function isMobileDeviceX($ua) {

    return preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $ua);

}

function base_url() {

    return 'https://cdncloaker.site/ui/';

}



setlocale(LC_TIME,'turkish');

function tarihCevir($tarih){

	/*$tarih = explode(" ", $tarih)[0];

	$saat = explode(" ", $tarih)[1];



	list($yil, $ay, $gun) = explode("/", $tarih);

	list($saat, $dakika, $saniye) = explode(":", $saat);*/



	return iconv('latin5','utf-8',strftime(' %d %B %Y %A %H:%M:%S',strtotime($tarih))); //belirtilen zamana ait

}



function seo($text)

{

    $find = array('Ç', 'Ş', 'Ğ', 'Ü', 'İ', 'Ö', 'ç', 'ş', 'ğ', 'ü', 'ö', 'ı', '+', '#');

    $replace = array('c', 's', 'g', 'u', 'i', 'o', 'c', 's', 'g', 'u', 'o', 'i', 'plus', 'sharp');

    $text = strtolower(str_replace($find, $replace, $text));

    $text = preg_replace("@[^A-Za-z0-9\-_\.\+]@i", ' ', $text);

    $text = trim(preg_replace('/\s+/', ' ', $text));

    $text = str_replace(' ', '-', $text);

    return $text;

}

?>