<?php

namespace App\Http\Controllers;

use App\Http\Controllers\OrioksParser as Parser;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ParserController extends Controller
{
    public function getMarks(Request $request):JsonResponse
    {
        $auth_string = $request -> header('Auth-String');
        $marks = Parser::getMarks($auth_string);
        $identity = $marks['identity'];
        $marks_json = $marks['json'];

        return response()->json($marks_json)->header('Identity', $identity);
    }

    public function getNewsId(Request $request): JsonResponse
    {
        $auth_string = $request -> header('Auth-String');
        $newsId = Parser::getNewsId($auth_string);

        return response()->json($newsId);
    }
}
