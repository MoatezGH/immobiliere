<?php


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\UserController;
use App\Http\Controllers\api\ServiceUserController;
use App\Http\Controllers\api\UserClassifiedController;


Route::middleware('api.key')->group(function () {
    Route::get('/users/check', [UserController::class, 'checkUser']);
    Route::post('/user/register', [UserController::class, 'register']);
    Route::post('/add/property', [UserController::class, 'store']);
    Route::post('/add/property/promoteur', [UserController::class, 'storePromoteur']);



    //user classified
    Route::get('/users/classified/check', [UserClassifiedController::class, 'checkUser']);

    Route::post('/register/classified', [UserClassifiedController::class, 'register']);

    Route::post('/add/classified', [UserClassifiedController::class, 'store']);


    //user service
    Route::get('/users/service/check', [ServiceUserController::class, 'checkUser']);

    Route::post('/register/service', [ServiceUserController::class, 'register']);

    Route::post('/add/service', [ServiceUserController::class, 'store']);
});

