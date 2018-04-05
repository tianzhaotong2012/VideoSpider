<?php
require(__DIR__   .  DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR  .'autoload.php');

define("COS_REGION","ap-hongkong");
define("COS_APPID","1253682758");
define("COS_KEY","AKIDZ4OWTTDDpTwE4qBp283Rp5A3kLn8CH7m");
define("COS_SECRET","gC6sUzNabYZYQ6bu1wnTp8TimfPOJ3f8");

$cosClient = new Qcloud\Cos\Client(array('region' => COS_REGION,
    'credentials'=> array(
        'appId' => COS_APPID,
        'secretId'    => COS_KEY,
        'secretKey' => COS_SECRET)));

#listBuckets
try {
    $result = $cosClient->listBuckets();
    print_r($result);
} catch (\Exception $e) {
    echo "$e\n";
}

try {
    $result = $cosClient->upload(
        $bucket='shixun-video-1253682758',
        $key = '111.mp4',
        $body=fopen("/var/www/html/wordpress/wordpress/wp-content/uploads/2017/05/Telstra-Unveils-Its-Smart-Home-Hub.mp4",'r+'));
    print_r($result);
    } catch (\Exception $e) {
    echo "$e\n";
}
