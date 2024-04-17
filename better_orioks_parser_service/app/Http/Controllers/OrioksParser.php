<?php
namespace App\Http\Controllers;
use DOMDocument;
use Illuminate\Support\Facades\Http;

class OrioksParser extends Controller
{
    public static function getNews(string $cookie): string
    {
        $html = Http::withHeaders([
            'Accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9',
            'Cookie' => $cookie,
            'User-agent' => 'OrioksParser'
        ]) -> get('https://orioks.miet.ru');

        $dom = new domDocument;
        libxml_use_internal_errors(true);
        $dom->loadHTML($html);
        libxml_clear_errors();
        $dom->preserveWhiteSpace = false;

        $name = '';
        $id = '';
        $url = '';
        foreach ($dom->getElementsByTagName('a') as $node) {
            if ($node->hasAttribute('href') and str_contains($node->getAttribute('href'), 'main/view-news?id=')) {
                $id = explode('=', $node->getAttribute('href'))[1];
                $url = $node->getAttribute('href');
                break;
            }
        }

        foreach ($dom->getElementsByTagName('td') as $node) {
            if (!str_contains($node->nodeValue, ':')) {
                $name = $node->nodeValue;
                break;
            }
        }

        return json_encode(array('name' => $name, 'id' => $id, 'url' => $url), JSON_UNESCAPED_UNICODE);
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
        $marks_and_subjects = $forang_div->nodeValue;
        $decoded_json = json_decode($marks_and_subjects, true);

        $result = [];

        $dises = $decoded_json['dises'];
        foreach ($dises as $dis) {
            $segments = $dis['segments'];
            foreach ($segments as $segment) {
                $kms = $segment['allKms'];
                foreach ($kms as $km) {
                    $type = $km['type'];
                    $balls = $km['balls'];
                    foreach ($balls as $ball) {
                        $result[] = array(
                            'subject_id' => $dis['id_science'],
                            'subject_name' => $dis['name'],
                            'control_event_id' => $ball['id_km'],
                            'control_event_name' => $type['name'],
                            'user_score' => $ball['ball']
                        );
                    }
                }
            }
        }

        return [
            'identity' => $identity,
            'json' => json_encode($result, JSON_UNESCAPED_UNICODE)
        ];
    }
}