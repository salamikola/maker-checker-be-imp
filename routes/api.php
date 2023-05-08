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


Route::group(['prefix' => 'admin', 'namespace' => 'Admin'], function () {
    Route::post('login', 'Auth\LoginController');
    Route::middleware(['auth:sanctum','check_entity_type:admin'])->group(function () {
        Route::post('create-user-request', 'User\CreateRequestController');
        Route::post('accept-user-request', 'User\AcceptRequestController');
        Route::post('reject-user-request', 'User\DeclineRequestController');
        Route::get('view-user-requests', 'User\FetchRequestController');
    });
});

