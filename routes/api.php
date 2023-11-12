<?php

use App\Http\Controllers\API\SendMailController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Redis;

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

Route::post("/sendEmail", [SendMailController::class, "sendOTP"]);
Route::post("/verificationOTP", [SendMailController::class, "verificationOTP"]);

Route::get('/getRedis', function (Request $req) {
    $name = Redis::get($req->name);
    return "success get data : {$name}";
});

Route::post('/setRedis', function (Request $req) {
    $name = Redis::set($req->name,$req->val,"EX",1*60);
    return "success set data {$req->name} : {$req->val}";
});