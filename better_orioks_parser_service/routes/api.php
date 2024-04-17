<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ParserController;

Route::get('v1/get_marks', [ParserController::class, 'getMarks']);

Route::get('v1/get_news_id', [ParserController::class, 'getNewsId']);
