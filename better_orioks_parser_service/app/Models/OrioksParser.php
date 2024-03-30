<?php
namespace App\Models;
use DOMDocument;

class OrioksParser{
    public static function getIdentity(string $cookie): string
    {
        $opts = array(
            'http'=>array(
                'method'=>"GET",
                'header'=>"Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9\r\n" .
                    $cookie.
                    "User-agent: User\r\n",
            ),
        );

        $context = stream_context_create($opts);
        file_get_contents('https://orioks.miet.ru/student/student', false, $context);

        $line = $http_response_header[10];

        return substr($line, 28, strpos($line, ';') - 28);

        //for ($i = 0; $i < sizeof($http_response_header); $i++) {
        //echo ("$http_response_header[$i]\n");
        //}

        //echo("$line\n");
        //echo($orioks_identity);
    }

    public static function parsePage(string $cookie): string
    {
        $opts = array(
            'http'=>array(
                'method'=>"GET",
                'header'=>"Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9\r\n" .
                    $cookie.
                    "User-agent: User\r\n",
            ),
        );

        $context = stream_context_create($opts);
        $html = file_get_contents('https://orioks.miet.ru/student/student', false, $context);

        $dom = new domDocument;

        libxml_use_internal_errors(true);

        $dom->loadHTML($html);

        libxml_clear_errors();

        $dom->preserveWhiteSpace = false;

        $forang_div = $dom->getElementById('forang');

        //if(!$forang_div)
        //{
            //die("Element not found");
        //}
        //echo "element found" . "\n";

        $marks_and_subjects = $dom->saveHTML($forang_div);
        $marks_and_subjects = substr($marks_and_subjects, 39, strlen($marks_and_subjects) - 39 - 6);

        //echo $marks_and_subjects . "\n";

        $decoded_json = json_decode($marks_and_subjects,true);

        $result_json = '"marks":[';

        $dises = $decoded_json['dises'];
        foreach($dises as $dis) {
            $segments = $dis['segments'];
            foreach ($segments as $segment) {
                $kms = $segment['allKms'];
                foreach ($kms as $km) {
                    $type = $km['type'];
                    $balls = $km['balls'];
                    foreach ($balls as $ball){
                        $result_json .= '{';
                        $result_json .= '"subject_id":' . $dis['id_science'] . ',';
                        $result_json .= '"subject_name":' . '"' . $dis['name'] . '"' . ',';
                        $result_json .= '"control_event_id":' . $ball['id_km'] . ',';
                        $result_json .= '"control_event_name":' . '"' . $type['name'] . '"' . ',';
                        $result_json .= '"user_score":' . $ball['ball'] . '},';
                    }
                }
            }
        }
        $result_json = rtrim($result_json, ',');
        $result_json .= ']';
        //echo $result_json;
        return $result_json;
    }

}


//$cookie = "Cookie: orioks_identity=765f6fb826fc6223689bc777e6bdd5fb1b0389e0a0bcd6d7676cbbe677cd5acea%3A2%3A%7Bi%3A0%3Bs%3A15%3A%22orioks_identity%22%3Bi%3A1%3Bs%3A52%3A%22%5B8211718%2C%225T1bZVKuSAooTkygP9SbmAdu9I-dBt_C%22%2C1209600%5D%22%3B%7D; _csrf=60fdcba93d62e0d155143ff6c9e99490192e8e8697095efc4bb89ef0782143b8a%3A2%3A%7Bi%3A0%3Bs%3A5%3A%22_csrf%22%3Bi%3A1%3Bs%3A32%3A%22gwT7Bb5IkJlLaRcsHNGc-NcfcQ79nC6j%22%3B%7D\r\n";
//[$orioks_identity, $html] = OrioksParser::getIdentity($cookie);
//OrioksParser::parsePage($html);

//echo OrioksParser::getIdentity("Cookie: orioks_identity=765f6fb826fc6223689bc777e6bdd5fb1b0389e0a0bcd6d7676cbbe677cd5acea%3A2%3A%7Bi%3A0%3Bs%3A15%3A%22orioks_identity%22%3Bi%3A1%3Bs%3A52%3A%22%5B8211718%2C%225T1bZVKuSAooTkygP9SbmAdu9I-dBt_C%22%2C1209600%5D%22%3B%7D; _csrf=60fdcba93d62e0d155143ff6c9e99490192e8e8697095efc4bb89ef0782143b8a%3A2%3A%7Bi%3A0%3Bs%3A5%3A%22_csrf%22%3Bi%3A1%3Bs%3A32%3A%22gwT7Bb5IkJlLaRcsHNGc-NcfcQ79nC6j%22%3B%7D\r\n");
//echo OrioksParser::parsePage("Cookie: orioks_identity=765f6fb826fc6223689bc777e6bdd5fb1b0389e0a0bcd6d7676cbbe677cd5acea%3A2%3A%7Bi%3A0%3Bs%3A15%3A%22orioks_identity%22%3Bi%3A1%3Bs%3A52%3A%22%5B8211718%2C%225T1bZVKuSAooTkygP9SbmAdu9I-dBt_C%22%2C1209600%5D%22%3B%7D; _csrf=60fdcba93d62e0d155143ff6c9e99490192e8e8697095efc4bb89ef0782143b8a%3A2%3A%7Bi%3A0%3Bs%3A5%3A%22_csrf%22%3Bi%3A1%3Bs%3A32%3A%22gwT7Bb5IkJlLaRcsHNGc-NcfcQ79nC6j%22%3B%7D\r\n");