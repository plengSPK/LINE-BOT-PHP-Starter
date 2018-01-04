<?php
$access_token = 'JphFMXiASaDZMH7axB1dsb0kgFe3QnKBTR56dxSsecyT+4o+3NGzzUhpAfXGk7krW/6P8pQQHuRGxGe/b00M5i2zlBcFdDmIYF6Y+kICN2Q1pkOz76P3z51GJa4kCB8cnbD44EjqOvM9uI4rNNOZ6gdB04t89/1O/w1cDnyilFU=';

$url = 'https://api.line.me/v1/oauth/verify';

$headers = array('Authorization: Bearer ' . $access_token);

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
$result = curl_exec($ch);
curl_close($ch);

echo $result;
