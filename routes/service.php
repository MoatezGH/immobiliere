<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RemontreController;
use App\Http\Controllers\ServicesUser\ServiceUserController;
use App\Http\Controllers\ServicesUser\AdminServiceController;
use App\Http\Controllers\ServicesUser\AnnonceServiceController;
// use App\Http\Controllers\Classified\ServiceUserRegisterController;


Route::get('service_user/register', [ServiceUserController::class, 'showRegistrationForm'])->name('service_user.register_form');


Route::post('service_user/register', [ServiceUserController::class, 'register'])->name('service_user.register');

Route::group(['middleware' => ['auth.service_user']], function () {

    

    //profile
    Route::get('/service_user_profile', [ServiceUserController::class, 'showProfile'])->name('show_profile_service');
    Route::post('update_profil_service', [ServiceUserController::class, 'updateProfile'])->name('updateProfileService');

    Route::post('/change-password-user-service', [ServiceUserController::class, 'changePassword'])->name('change.user.password.service');


    //annonce
    Route::get('/service_user_add', [AnnonceServiceController::class, 'showAdd'])->name('service_show_add');

    Route::post('/service_user_store', [AnnonceServiceController::class, 'store'])->name('store_service');

    Route::get('/service_user_add_images/{service}', [AnnonceServiceController::class, 'showAddImages'])->name('show_add_images_service');


    Route::get('/service_user_update_images/{service}', [AnnonceServiceController::class, 'showUpdateImages'])->name('show_update_images_service');


    Route::post('/service_update_images/{service}', [AnnonceServiceController::class, 'AddImages'])->name('add_images_service');

    Route::get('/services/all', [AnnonceServiceController::class, 'index'])->name('index_service');


    Route::delete('/delete-image-service/{id}', [AnnonceServiceController::class, 'deleteImage'])->name('delete_image_service');


    Route::get('/service_update/{service}', [AnnonceServiceController::class, 'showUpdate'])->name('update_service');

    Route::put('/service_update/{id}', [AnnonceServiceController::class, 'update'])->name('service.update');

    Route::delete('/service/destroy/{id}', [AnnonceServiceController::class, 'destroy'])->name('service.destroy');

    // //dashboard
    // Route::get('/classified_user_dashboard', [ClassifiedUserRegisterController::class, 'dashboard'])->name('classified_user_dashboard');

    // Route::get('/classified_user_profil', [ClassifiedUserRegisterController::class, 'showProfile'])->name('classified_user_profil');
    Route::post('/service/remonte/{annonceId}', [RemontreController::class, 'remonter'])->name('service.remonter');

    
});