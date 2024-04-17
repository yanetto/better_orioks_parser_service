<?php

namespace App\Http\Controllers;

use App\Http\Controllers\OrioksParser as Parser;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ParserController extends Controller
{
    public function getMarks(Request $request): JsonResponse
    {
        $auth_string = $request -> header('Auth-String');
        $marks = Parser::getMarks($auth_string);
        $identity = $marks['identity'];
        $marks_json = $marks['json'];

        return response()->json($marks_json)->header('Identity', $identity);
    }

    public function getNews(Request $request): JsonResponse
    {
        $auth_string = $request -> header('Auth-String');
        $news = Parser::getNews($auth_string);

        return response()->json($news);
    }
}
