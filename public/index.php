<?php
header('Content-Type: application/json');
ini_set("display_errors", "1");
error_reporting(E_ALL);

include __DIR__ . '/../config.php';
include __DIR__ . '/../src/classes/PdoHelper.php';
include __DIR__ . '/../src/classes/Weather.php';

$headers = getallheaders();
$result = [];

if (!isset($headers['X-Auth-Token']) || $headers['X-Auth-Token'] != TOKEN) {
    $result = [
        'error' => true,
        'message' => 'Wrong X-AUTH-TOKEN'
    ];
    die(json_encode($result));
}

$day = $_GET['day'];

try {
    $date = new DateTime($day);
} catch (\Exception $exception) {
    $result = ['error' => true, 'message' => 'Invalid day format.'];
    die(json_encode($result));
}

if (!$date || is_null($day)) {
    $result = ['error' => true, 'message' => 'Wrong day format.'];
    die(json_encode($result));
}

$weather_class = new Weather();
$result = $weather_class->getDayWeather(CITY, $date);

print json_encode($result);
exit;

