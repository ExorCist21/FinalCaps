<?php

use Yasser\Agora\RtcTokenBuilder;


function prx($arr) {
    echo"<pre>";print_r($arr);die();
}

function createAgoraProject($name) {
    $customerKey = env('CUSTOMER_KEY');

    $customerSecret = env('CUSTOMER_SECRET');

    $credentials = $customerKey . ":" . $customerSecret;

    $base64Credentials = base64_encode($credentials);

    $arr_header = "Authorization: Basic " . $base64Credentials;

    $curl = curl_init();

    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://api.agora.io/dev/v1/project',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => '{"name": "' . $name . '",
        "enable_sign_key": true }',
        CURLOPT_HTTPHEADER => array(
            $arr_header, 'Content-Type: application/json'
        ),
    ));

    $response = curl_exec($curl);

    curl_close($curl);
    $result = json_decode($response);

    //prx($result);
    return $result;
}

function createToken($appId, $appCertificate, $channelName)
{
    $uid = rand(1000, 9999); // or you can use any UID you want
    $role = RtcTokenBuilder::RoleAttendee;
    $expireTimeInSeconds = 3600; // 1 hour validity
    $currentTimestamp = now()->timestamp;
    $privilegeExpiredTs = $currentTimestamp + $expireTimeInSeconds;

    $token = RtcTokenBuilder::buildTokenWithUid(
        $appId,
        $appCertificate,
        $channelName,
        $uid,
        $role,
        $privilegeExpiredTs
    );

    return $token;
}

function generateRandomString($length = 7) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}