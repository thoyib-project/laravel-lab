<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TestController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get('/staffmanager', function () {
    return view('staffmanager/index');
});
Route::get('/testTrait', [TestController::class, 'index']);

Route::middleware('auth')->group(function (){
    Route::middleware('role:admin')->group(function () {
        Route::get('/', function () {
            return view('welcome');
        });
    });

    Route::middleware('role:toko')->group(function () {
        Route::get('/', function () {
            return view('welcome');
        });
    });
});
