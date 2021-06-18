<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
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

Route::post("login",[AuthController::class,'login']);
Route::post('register',[AuthController::class,'register']);
Route::group(['middleware'=>'auth:api'],function (){
    Route::apiResource("users",UserController::class);
});
// or the commented stuff
//Route::get('users',[UserController::class,'index']);
//Route::get('users/{id}',[UserController::class,'show']);
//Route::post('users',[UserController::class,'store']);
//Route::put('users/{id}',[UserController::class,'update']);
//Route::delete('users/{id}',[UserController::class,'destroy']);
