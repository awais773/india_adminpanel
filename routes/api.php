<?php

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('register',[App\Http\Controllers\api\AuthController::class,'register']);
Route::post('login',[App\Http\Controllers\api\AuthController::class,'login']);

Route::middleware('auth:api')->group(function(){
Route::get('get-user',[App\Http\Controllers\api\AuthController::class,'userinfo']);
});



Route::apiResource('clients', App\Http\Controllers\api\ClientController::class);
Route::apiResource('positions', App\Http\Controllers\api\PositionController ::class);
Route::apiResource('status', App\Http\Controllers\api\StatusController ::class);
Route::apiResource('currency', App\Http\Controllers\api\CurrencyController ::class);
Route::apiResource('role', App\Http\Controllers\api\RoleController ::class);
Route::apiResource('roleuser', App\Http\Controllers\api\RoleUserController ::class);
Route::apiResource('resume', App\Http\Controllers\api\ResumeController ::class);
Route::apiResource('clientcommercial', App\Http\Controllers\api\ClientCommercialController ::class);

Route::get('getAll',[App\Http\Controllers\api\ResumeController::class,'getAll']);

Route::get('statusGet',[App\Http\Controllers\api\ResumeController::class,'resumeGet']);
Route::post('storeLog',[App\Http\Controllers\api\ResumeController::class,'storeLog']);
Route::get('geLog/{id}',[App\Http\Controllers\api\ResumeController::class,'geLog']);


