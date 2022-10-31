<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\http\Controllers\api\authController;
use App\http\Controllers\api\clientController;
use App\http\Controllers\api\PositionController ;
use App\http\Controllers\api\CurrencyController ;
use App\http\Controllers\api\RoleController ;




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
Route::post('register',[authController::class,'register']);
Route::post('login',[authController::class,'login']);

Route::middleware('auth:api')->group(function(){
Route::get('get-user',[authController::class,'userinfo']);
Route::resource('client',clientController::class);
Route::resource('/positions',PositionController ::class);
Route::resource('/currency',CurrencyController ::class);
Route::resource('/role',RoleController ::class);

});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});



