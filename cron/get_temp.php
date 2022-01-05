<?php
ini_set("display_errors", "1");
error_reporting(E_ALL);

include __DIR__ . '/../config.php';
include __DIR__ . '/../src/classes/PdoHelper.php';
include __DIR__ . '/../src/classes/Weather.php';

$request_link = 'https://api.openweathermap.org/data/2.5/weather?q=' . CITY . '&appid=' . OPEN_WEATHER_API;

//CURL BLOCK
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $request_link);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$response = curl_exec($ch);

curl_close($ch);

$response = json_decode($response, true);

if (isset($response['main']['temp'])) {
    $weather_class = new Weather();
    $weather_class->addWeather(CITY, $response['main']['temp']);
}

