<?php

use App\Http\Controllers\Api\AuthApiController;
use App\Http\Controllers\Api\QuestionsApiController;
use App\Http\Controllers\Api\SendEmailApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('log-in', [AuthApiController::class, 'login']);
Route::post('sign-up', [AuthApiController::class, 'register']);
Route::get('questions', [QuestionsApiController::class, 'index']);
Route::post('send-email', [SendEmailApiController::class, 'send']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
