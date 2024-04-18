<?php

namespace App\Http\Controllers;

use App\Http\Controllers\OrioksParser as Parser;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;
use PHPUnit\Exception;

/**
 * @OA\Info(
 *     title="Better Orioks Parser Service API",
 *     version="1",
 *     @OA\Contact(
 *         email="kamshilovaes@yandex.ru",
 *         name="Ekaterina"
 *     )
 * )
 */

class ParserController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/v1/marks",
     *     tags={"Marks"},
     *     summary="Get marks",
     *
     *     @OA\Parameter (
     *           name="Auth-String",
     *           in="query",
     *           required=true,
     *           description="Authorization String"
     *     ),
     *
     *     @OA\Response(
     *          response=200,
     *          description="Successful response",
     *          @OA\JsonContent(
     *             @OA\Property(property="subject_id", type="int"),
     *             @OA\Property(property="subject_name", type="string"),
     *             @OA\Property(property="control_event_id", type="int"),
     *             @OA\Property(property="control_event_name", type="string"),
     *             @OA\Property(property="user_score", type="float")
     *          )
     *      ),
     *      @OA\Response(
     *           response=401,
     *           description="Unauthorized"
     *      )
     * )
     */
    public function getMarks(Request $request): JsonResponse|string
    {
        $encrypted = $request->query('Auth-String');
        try{
            $auth_string = Crypt::decrypt($encrypted);
        } catch (DecryptException $exception){
            return $exception->getMessage();
        }

        $marks = Parser::getMarks((string)$auth_string);

        if ($marks == null){
            return '401 Unauthorized';
        }

        $identity = $marks['identity'];
        $marks_json = $marks['json'];

        return response()->json($marks_json)->header('Identity', $identity);
    }

    /**
     * @OA\Get(
     *     path="/api/v1/news",
     *     tags={"News"},
     *     summary="Get last news",
     *     @OA\Parameter (
     *            name="Auth-String",
     *            in="query",
     *            required=true,
     *            description="Authorization String"
     *     ),
     *
     *     @OA\Response(
     *          response=200,
     *          description="Successful response",
     *          @OA\JsonContent(
     *             @OA\Property(property="name", type="string"),
     *             @OA\Property(property="id", type="int"),
     *             @OA\Property(property="url", type="string")
     *          )
     *      ),
     *      @OA\Response(
     *           response=401,
     *           description="Unauthorized"
     *      )
     * )
     */
    public function getNews(Request $request): JsonResponse|string
    {
        $encrypted = $request->query('Auth-String');
        try{
            $auth_string = Crypt::decrypt($encrypted);
        } catch (DecryptException $exception){
            return $exception->getMessage();
        }

        $news = Parser::getNews((string)$auth_string);

        if($news == null){
            return '401 Unauthorized';
        }

        return response()->json($news);
    }
}
