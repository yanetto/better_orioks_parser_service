<?php
namespace App\Http\Controllers;
use DOMDocument;
use Illuminate\Support\Facades\Http;

class OrioksParser extends Controller
{
    public static function getNewsId(string $cookie): string
    {
        $html = Http::withHeaders([
            'Accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9',
            'Cookie' => $cookie,
            'User-agent' => 'OrioksParser'
        ]) -> get('https://orioks.miet.ru/student/student');

        $dom = new domDocument;
        libxml_use_internal_errors(true);
        $dom->loadHTML($html);
        libxml_clear_errors();
        $dom->preserveWhiteSpace = false;

        foreach ($dom->getElementsByTagName('a') as $node) {
            if ($node->hasAttribute('href') and str_contains($node->getAttribute('href'), 'main/view-news?id=')) {
                return explode('=', $node->getAttribute('href'))[1];
            }
        }
        return 'error';
    }

    public static function getMarks(string $cookie): array
    {
        $html = Http::withHeaders([
            'Accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9',
            'Cookie' => $cookie,
            'User-agent' => 'OrioksParser'
        ]) -> get('https://orioks.miet.ru/student/student');

        $identity = $html -> header('Set-Cookie');

        $parts = explode(',', $identity)[1];
        $identity = explode(';', $parts)[0];

        $dom = new domDocument;
        libxml_use_internal_errors(true);
        $dom->loadHTML($html -> body());
        libxml_clear_errors();
        $dom->preserveWhiteSpace = false;

        $forang_div = $dom->getElementById('forang');

        $marks_and_subjects = $dom->saveHTML($forang_div);
        $marks_and_subjects = substr($marks_and_subjects, 39, strlen($marks_and_subjects) - 39 - 6);

        $decoded_json = json_decode($marks_and_subjects, true);

        $result = [];
        $list_result = [];

        $dises = $decoded_json['dises'];
        foreach ($dises as $dis) {
            $segments = $dis['segments'];
            foreach ($segments as $segment) {
                $kms = $segment['allKms'];
                foreach ($kms as $km) {
                    $type = $km['type'];
                    $balls = $km['balls'];
                    foreach ($balls as $ball) {
                        $result[] = [
                            'subject_id' => $dis['id_science'],
                            'subject_name' => $dis['name'],
                            'control_event_id' => $ball['id_km'],
                            'control_event_name' => $type['name'],
                            'user_score' => $ball['ball']
                        ];
                        $list_result[] = $result;
                        $result = [];
                    }
                }
            }
        }

        return [
            'identity' => $identity,
            'json' => json_encode($list_result, JSON_UNESCAPED_UNICODE)
        ];
    }
}