<?php

function classLoader($class)
{
    $path = str_replace('\\', DIRECTORY_SEPARATOR, $class);
    $file = __DIR__ . '/src/' . $path . '.php';
    if (file_exists($file)) {
        require_once $file;
    }
}
spl_autoload_register('classLoader');
use JPush\Client as JPush;

//echo 'ddd';
//die;
/*$app_key = getenv('050664198e9b37cd7cbe4346');
$master_secret = getenv('22376f850f0ee02129dbb6bc');
$registration_id = getenv('');*/
$app_key = '050664198e9b37cd7cbe4346';
$master_secret = '22376f850f0ee02129dbb6bc';

$client = new JPush($app_key, $master_secret);
print_r($client);
die;
$push_payload = $client->push()
    ->setPlatform('all')
    ->addAllAudience()
    ->setNotificationAlert('Hi, JPush');
try {
    $response = $push_payload->send();
    print_r($response);
} catch (\JPush\Exceptions\APIConnectionException $e) {
    // try something here
    print $e;
} catch (\JPush\Exceptions\APIRequestException $e) {
    // try something here
    print $e;
}