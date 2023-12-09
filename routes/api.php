<?php

use App\Http\Controllers\InformationModelController;
use App\Http\Controllers\Api\AuthController;
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

// auth
Route::post('register', [App\Http\Controllers\Api\AuthController::class, 'register']);
Route::post('login', [App\Http\Controllers\Api\AuthController::class, 'login']);

// get user data
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//posts
Route::apiResource('/articles', App\Http\Controllers\Api\ArticleController::class);


// Information Model API
Route::middleware('auth:sanctum')->group(function () {
    // user
    Route::get('/model', [InformationModelController::class, "index"]);
});