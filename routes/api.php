<?php

use App\Http\Controllers\TwilioWebhookController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('test-llm', function() {
    $url = 'https://upload.wikimedia.org/wikipedia/commons/8/8f/Arroz%2C_feij%C3%A3o_e_farofa.jpg';
    $res = (new \App\Modules\LLM\OpenAIDriver())->getCalories($url);
});

Route::post('twilio-webhook', TwilioWebhookController::class);

