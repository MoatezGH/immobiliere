<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RemontreController;
use App\Http\Controllers\Classified\AnnonceController;
use App\Http\Controllers\Classified\AdminClassifiedController;
use App\Http\Controllers\Classified\ClassifiedUserRegisterController;
// use App\Http\Controllers\ClassifiedController;


Route::get('classifed_user/register', [ClassifiedUserRegisterController::class, 'showRegistrationForm'])->name('classified_user.register_form');

Route::post('classified_user/register', [ClassifiedUserRegisterController::class, 'register'])->name('classified_user.register');


// Route::get('/all/classified', [AnnonceController::class, 'index_front'])->name('index_classified_front');


Route::match(['get', 'post'], "/ventes-diverses", [AnnonceController::class, 'index_front'])->name("index_classified_front");

Route::get('/classified/info/{classified}', [AnnonceController::class, 'get_classified_info'])->name('classified_info_front');


Route::group(['middleware' => ['auth.classified_user']], function () {

    Route::get('/classified_user_dashboard', [ClassifiedUserRegisterController::class, 'dashboard'])->name('classified_user_dashboard');

    Route::get('/classified_user_profil', [ClassifiedUserRegisterController::class, 'showProfile'])->name('classified_user_profil');

    //profile
    Route::get('/classified_user_profile', [ClassifiedUserRegisterController::class, 'showProfile'])->name('show_profile_classified');
    
    Route::post('update_profil_classified', [ClassifiedUserRegisterController::class, 'updateProfile'])->name('updateProfileClassified');

    Route::post('/change-password-user-classified', [ClassifiedUserRegisterController::class, 'changePassword'])->name('change.user.password.classified');


    //annonce
    Route::get('/classified_user_add', [AnnonceController::class, 'showAdd'])->name('show_add');

    Route::post('/classified_user_store', [AnnonceController::class, 'store'])->name('store_classified');

    Route::get('/classified_user_add_images/{classified}', [AnnonceController::class, 'showAddImages'])->name('show_add_images');


    Route::get('/classified_user_update_images/{classified}', [AnnonceController::class, 'showUpdateImages'])->name('show_update_images');


    Route::post('/classified_update_images/{classified}', [AnnonceController::class, 'AddImages'])->name('add_images_classified');

    Route::get('/classified/all', [AnnonceController::class, 'index'])->name('index_classified');


    Route::delete('/delete-image-classified/{id}', [AnnonceController::class, 'deleteImage'])->name('delete_image_classified');


    Route::get('/classified_update/{classified}', [AnnonceController::class, 'showUpdate'])->name('update_classified');

    Route::put('/classifieds_update/{id}', [AnnonceController::class, 'update'])->name('classifieds.update');

    Route::delete('/classifieds/destroy/{id}', [AnnonceController::class, 'destroy'])->name('classifieds.destroys');

    Route::post('/classified/remonte/{annonceId}', [RemontreController::class, 'remonter'])->name('classified.remonter');
});


Route::group(['middleware' => ['auth']], function () {

    Route::get('/classified_admin', [AdminClassifiedController::class, 'index'])->name('admin_classifieds');

    Route::get('/classifieds_info/{id}', [AdminClassifiedController::class, 'get_classified_info'])->name('classifieds.admin.info');

    Route::put('/classifieds_update_status/{id}', [AdminClassifiedController::class, 'updateStatusClassified'])->name('classifieds.update.status');


    Route::delete('/classifieds/{id}', [AdminClassifiedController::class, 'destroy'])->name('classifieds.destroy.admin');
});