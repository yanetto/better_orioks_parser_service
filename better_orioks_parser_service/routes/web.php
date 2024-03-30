<?php
use App\Models\OrioksParser as Parser;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/identity', function () {
    return Parser::getIdentity("Cookie: orioks_identity=765f6fb826fc6223689bc777e6bdd5fb1b0389e0a0bcd6d7676cbbe677cd5acea%3A2%3A%7Bi%3A0%3Bs%3A15%3A%22orioks_identity%22%3Bi%3A1%3Bs%3A52%3A%22%5B8211718%2C%225T1bZVKuSAooTkygP9SbmAdu9I-dBt_C%22%2C1209600%5D%22%3B%7D; _csrf=60fdcba93d62e0d155143ff6c9e99490192e8e8697095efc4bb89ef0782143b8a%3A2%3A%7Bi%3A0%3Bs%3A5%3A%22_csrf%22%3Bi%3A1%3Bs%3A32%3A%22gwT7Bb5IkJlLaRcsHNGc-NcfcQ79nC6j%22%3B%7D\r\n");
});

Route::get('/get_marks', function () {
    return Parser::parsePage("Cookie: orioks_identity=765f6fb826fc6223689bc777e6bdd5fb1b0389e0a0bcd6d7676cbbe677cd5acea%3A2%3A%7Bi%3A0%3Bs%3A15%3A%22orioks_identity%22%3Bi%3A1%3Bs%3A52%3A%22%5B8211718%2C%225T1bZVKuSAooTkygP9SbmAdu9I-dBt_C%22%2C1209600%5D%22%3B%7D; _csrf=60fdcba93d62e0d155143ff6c9e99490192e8e8697095efc4bb89ef0782143b8a%3A2%3A%7Bi%3A0%3Bs%3A5%3A%22_csrf%22%3Bi%3A1%3Bs%3A32%3A%22gwT7Bb5IkJlLaRcsHNGc-NcfcQ79nC6j%22%3B%7D\r\n");
});