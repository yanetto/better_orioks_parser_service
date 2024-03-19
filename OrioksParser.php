<?php

$opts = array(
    'http'=>array(
        'method'=>"GET",
        'header'=>"Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9\r\n" .
            "Cookie: orioks_identity=765f6fb826fc6223689bc777e6bdd5fb1b0389e0a0bcd6d7676cbbe677cd5acea%3A2%3A%7Bi%3A0%3Bs%3A15%3A%22orioks_identity%22%3Bi%3A1%3Bs%3A52%3A%22%5B8211718%2C%225T1bZVKuSAooTkygP9SbmAdu9I-dBt_C%22%2C1209600%5D%22%3B%7D; _csrf=60fdcba93d62e0d155143ff6c9e99490192e8e8697095efc4bb89ef0782143b8a%3A2%3A%7Bi%3A0%3Bs%3A5%3A%22_csrf%22%3Bi%3A1%3Bs%3A32%3A%22gwT7Bb5IkJlLaRcsHNGc-NcfcQ79nC6j%22%3B%7D\r\n" .
            "User-agent: User\r\n"
    )
);

$context = stream_context_create($opts);

$file = file_get_contents('https://orioks.miet.ru/student/student', false, $context);

//echo("$file");

//for ($i = 0; $i < sizeof($http_response_header); $i++) {
    //echo ("$http_response_header[$i]\n");
//}
$line = $http_response_header[10];
$orioks_identity = substr($line, 28, strpos($line, ';') - 28);
echo("$line\n");
echo($orioks_identity);

