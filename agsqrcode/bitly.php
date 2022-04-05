<?php
/*$url = 'https://macappstudioserver.com/phpqrcode-master1/123.php?qr=RES54L9';
$login = 'aravind16993';
$appkey = 'R_16f0e7a2f86343159e0b221e8d1760a0';*/
$url = 'http://3.109.167.11/agsqrcode/qrdownload.php?qr=WLZ29KZ';
$login = 'hsemak';
$appkey = 'R_ebdf9c13673f48d483b57d90e348f2d1';

$ch = curl_init('http://api.bitly.com/v3/shorten?login='.$login.'&apiKey='.$appkey.'&longUrl='.$url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$result = curl_exec($ch);
//print_r(json_decode($result));
//print_r($result);
$result1 = (json_decode($result));
$temp = $result1->data->url;
echo $temp;