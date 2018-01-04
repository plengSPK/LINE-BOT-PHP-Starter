<?php
$access_token = 'Eqd+DHouXqXO0SeRpTNRhDVCb1ibCVn+Yhf1EcqDS9+wu/Lck42VR4fnvqUlsmPvW/6P8pQQHuRGxGe/b00M5i2zlBcFdDmIYF6Y+kICN2SFtbF4JoUeezM2/Zj11hPb6GAl6214m9I5Oh3kwljB4wdB04t89/1O/w1cDnyilFU=';

$url = 'https://api.line.me/v1/oauth/verify';

$headers = array('Authorization: Bearer ' . $access_token);

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
$result = curl_exec($ch);
curl_close($ch);

echo $result;
