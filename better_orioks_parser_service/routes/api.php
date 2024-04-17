<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ParserController;

Route::get('v1/marks', [ParserController::class, 'getMarks']);

Route::get('v1/news', [ParserController::class, 'getNews']);
