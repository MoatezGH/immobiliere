<?php

use App\Models\City;
use App\Models\Logo;
use App\Models\User;
use App\Models\Store;
use App\Models\Slider;
use App\Models\Company;
use App\Models\Partner;
use App\Models\Category;
use App\Models\Property;
use App\Models\Operation;
use App\Models\PromoteurProperty;
use App\Models\Property_features;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SiteController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\SiteMapController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\RemontreController;
use App\Http\Controllers\PartenaireController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\StatistiqueController;
use App\Http\Controllers\Admin\Ads\AdsController;
use App\Http\Controllers\Immo\AuthImmoController;
use App\Http\Controllers\Immo\AnnoceurImmoController;
use App\Http\Controllers\Admin\Slider\SliderController;
use App\Http\Controllers\Admin\User\AdminUsersController;
use App\Http\Controllers\Admin\StatistiqueAdminController;
use App\Http\Controllers\Admin\Store\AdminStoreController;
use App\Http\Controllers\ServicesUser\ServiceUserController;
use App\Http\Controllers\ServicesUser\AdminServiceController;

use App\Http\Controllers\Classified\AdminClassifiedController;

use App\Http\Controllers\promoteur\PromoteurPropertyController;
use App\Http\Controllers\ServicesUser\AnnonceServiceController;
use App\Http\Controllers\Admin\property_premium\PropertyPremiumController;
use App\Http\Controllers\Admin\ServiceWeb\ServiceWebController;


use Illuminate\Support\Facades\Http;

Route::get('/test', function () {
    $url = 'https://les-annonces.com.tn/api/users/check';
    $email = 'ouertanihela13@gmail.com';
    $apiKey = env('API_KEY_TWO'); // Ensure you have this key in your .env file

    try {
        // Make the GET request to the external API
        $response = Http::withHeaders([
            'X-API-KEY' => $apiKey,
        ])->get($url, [
            'email' => $email,
        ]);

        // Log the response for debugging
        \Log::info('API Response:', [
            'status_code' => $response->status(),
            'response_body' => $response->body(),
        ]);

        // Return the API response as JSON
        return response()->json([
            'status_code' => $response->status(),
            'response' => $response->json(),
        ]);
    } catch (\Exception $e) {
        // Log the error and return an error response
        \Log::error('API Request Failed:', [
            'message' => $e->getMessage(),
            'trace' => $e->getTraceAsString(),
        ]);

        return response()->json([
            'error' => 'API request failed',
            'message' => $e->getMessage(),
        ], 500);
    }
});







Route::get('/cherche/{category?}-{operation?}-{city?}-{area?}', [PropertyController::class, 'search'])->name('search.human');
// Route::get('/update_db', [App\Http\Controllers\UpdateDbController::class, 'saveServiceCategories'])->name('saveServiceCategories');
Route::get('/generate-sitemap', [SiteMapController::class, 'generateSitemap']);

Route::post('/statistique', [StatistiqueController::class, 'save'])->name('save_statistique');
// Route::get('/store_slug', [SiteController::class, 'add_slug_for_store']);
Route::get('/', [SiteController::class, 'index']);
Route::get('/account_type', function () {
    $categories = Category::all();
    return view('auth.account_type', compact('categories'));
})->middleware('guest')->name('account_type');


//------------term&condition-----------
Route::get("/term_condition",function(){
    return view("term_and_condition");
})->name('term_condition');


//------------about_us-----------
Route::get("/about_us",function(){
    return view("about_us");
})->name('about_us');

//------------contact-----------
Route::get("/contact",function(){
    return view("contact");
})->name('contact');
//----------------service------------------------------------
Route::get(
    '/service',
    [SiteController::class, 'soon']
)->name('service');

Route::get(
    '/debaras',
    [SiteController::class, 'soon']
)->name('deba');

// ------------------------email--------------------------------
Route::post('/send-email-client', [SiteController::class, 'sendEmailClient'])->name('send.email.client');
// ------------------------end email--------------------------------

Route::get('/get-areas/{id}', [SiteController::class, 'get_area_by_id'])->name('area_by_id');

Route::get('/stores', [SiteController::class, 'get_all_stores'])->name('stores');

Route::get('/partenaire_redirect/{id}', [PartenaireController::class, 'incrementViewCount'])->name('incrementViewCountPartenaire');



//back
Auth::routes();

//------------------------------------------compte immobilier-----------------------------------------------

Route::get('/register/annonceur_immobilier', [AuthImmoController::class, 'showRegistrationForm'])->middleware('guest')->name('get_register_immo');

Route::post('/register/annonceur_immobilier_register', [AuthImmoController::class, 'register'])->name('register_immo');

Route::get('signout', [AuthImmoController::class, 'signOut'])->name('signout');

//-------------------------------------------property-----------------------------------------------------------
Route::match(['get', 'post'], "/properties", [PropertyController::class, 'get_all_properties_front'])->name("all_properties");

Route::get('/propertie_/{property}', [PropertyController::class, 'get_prop_info'])->name('prop_info');

Route::get('/propertie_promoteur/{property}', [PropertyController::class, 'get_prop_promoteur_info'])->name('prop_info_promoteur');
//---------------------------------------property promoteur-----------------------------------------------
Route::match(['get', 'post'], "/properties/promoteur", [PromoteurPropertyController::class, 'get_all_properties_promoteur_front'])->name("all_properties_promoteur");

//-------------------------------------------------------stores-------------------------------------------------
Route::match(['get', 'post'], "/store/{slug}", [SiteController::class, 'get_store_products'])->name("all_product_store");

//--------------------------------------------end stores-------------------------------------------------


Route::group(['middleware' => 'auth'], function () {
    Route::get('/dashboard/annonceur_immobilier', [AnnoceurImmoController::class, 'dashboard'])->name('dashboard_annonceur_immobilier');
    Route::get('/profile', [AnnoceurImmoController::class, 'profile'])->name('profile_annonceur_immobilier');


    ///-------------------------------------------property------------------------------------------------
    Route::get('/add_property', [PropertyController::class, 'get_add'])->name('get_add_property');
    Route::post('/store_property', [PropertyController::class, 'store'])->name('strore_property');
    Route::get('/all_properties', [PropertyController::class, 'get_user_properties'])->name('all_user_property');
    Route::delete('/deletProperties/{property}', [PropertyController::class, 'delete'])->name('properties.destroy');
    Route::get('/edit_properties/{property}', [PropertyController::class, 'EditProperty'])->name('EditProperty');
    Route::post('/update_property/{property}', [PropertyController::class, 'update'])->name('update_property');

    ///------------------------------------------endproperty----------------------------------------------------


    //-----------------------------------------------propmoteur--------------------------------------------
    Route::post('/change-password-user', [UserController::class, 'changePassword'])->name('change.user.password');
    Route::post('/promoteur_store_property', [PromoteurPropertyController::class, 'store'])->name('promoteur_store_property');
    Route::get('/all_properties_promoteur', [PromoteurPropertyController::class, 'get_promoteur_properties'])->name('all_promoteur_property');
    Route::get('/edit_propertie_/{property}', [PromoteurPropertyController::class, 'EditProperty'])->name('EditPropertyPromoteur');
    Route::post('/update_promoteur_property/{property}', [PromoteurPropertyController::class, 'update'])->name('update_promoteur_property');
    Route::delete('/delet_property_promoteur/{property}', [PromoteurPropertyController::class, 'delete'])->name('property.promotuer.destroy');
    
    ///upload
    ///-------------properties
    Route::get('/properties/{property}/upload', [PropertyController::class, 'showUpload'])->name('properties.upload');
    Route::post('/properties/{property}/upload', [PropertyController::class, 'uploaded'])->name('properties.uploadfile');

    ///-------------properties promoteur

    Route::get('/properties_pro/{property}/upload', [PromoteurPropertyController::class, 'showUpload'])->name('properties.pro.upload');

    Route::post('/properties_pro/{property}/upload', [PromoteurPropertyController::class, 'uploaded'])->name('properties.promoteur.uploadfile');

    Route::get('/edit_properties/{property}/upload', [PromoteurPropertyController::class, 'showEditUpload'])->name('edit_properties.pro.upload');

    Route::post('/edit_properties/{property}/upload', [PromoteurPropertyController::class, 'editUploadfile'])->name('edit_properties.pro.uploadFile');
    //end upload
    //-------------------------------------------------------store---------------------------------------------
    Route::post('update_store', [StoreController::class, 'updateStore'])->name('updateStore');
    Route::post('change_logo', [UserController::class, 'changeLogo'])->name('changeLogo');
    Route::post('update_profil', [UserController::class, 'updateProfile'])->name('updateProfile');


    //---------------------------------------------------------image--------------------------------------------
    Route::delete('/delete-image/{id}', [PropertyController::class, 'deleteImage'])->name('delete_image');

    Route::delete('/delete-image-promoteur/{id}', [PromoteurPropertyController::class, 'deleteImage'])->name('delete_image_promoteur');

    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('dashboard_admin');

    //--------------------------admin properties promoteur----------------
    Route::match(['get', 'post'], '/all_properties_admin_promoteur', [AdminController::class, 'get_all_property_promoteur'])->name('all_admin_property_promoteur');

    Route::get('/admin/property/promoteur/{id}', [AdminController::class, 'get_prop_prom_info'])->name('admin_property_promoteur_info');
    //-------------------------- end admin properties promoteur----------------


    //---------------------------------------------admin properties-----------------------------------------

    Route::match(['get', 'post'], '/all_properties_company_admin', [AdminController::class, 'get_all_property_company'])->name('all_admin_company_property');

    Route::match(['get', 'post'], '/all_properties_particulier_admin', [AdminController::class, 'get_all_property_particulier'])->name('all_admin_particulier_property');

    Route::get('/admin/property/{id}', [AdminController::class, 'get_prop_info'])->name('admin_property_info');


    //---------------------------change status-----------------
    Route::put('/properties/{id}/update-status', [AdminController::class, 'updateStatusProp'])->name('properties.update-status');

    Route::put('/properties/promoteur/{id}/update-status', [AdminController::class, 'updateStatusPropPromoteur'])->name('properties.promoteur.update-status');

    //---------------------------end change status-----------------

    //---------------------------edit property----------------------------

    Route::get('/admin/edit_properties/{property}', [AdminController::class, 'EditProperty'])->name('AdminEditProperty');

    Route::post('/admin_update_property/{property}', [AdminController::class, 'updateProperty'])->name('update_admin_property');

    Route::get('/admin/edit_properties_promoteur/{property}', [AdminController::class, 'EditPropertyPromoteur'])->name('AdminEditPropertyPromoteur');

    Route::post('/admin_update_promoteur_property/{property}', [AdminController::class, 'updatePropertyPromoteur'])->name('update_admin_property_promoteur');
    //---------------------------end edit property----------------------------



    //---------------------------delete property----------------------------

    Route::delete('/admin_delet_properties/{property}', [AdminController::class, 'delete'])->name('admin.properties.destroy');

    Route::delete('/admin_delet_properties_promoteur/{property}', [AdminController::class, 'deletePrpertyPromoteur'])->name('admin.property.promoteur.destroy');
    //---------------------------end delete property----------------------------

    //--------------------------------------------------end admin properties------------------------------------

    //------------------------------------admin users
    Route::match(['get', 'post'], '/all_users_admin', [AdminUsersController::class, 'index'])->name('all_users_admin');
    Route::post('/users/{user}/disable', [AdminUsersController::class, 'disable'])->name('users.disable');
    Route::post('/users/{user}/active', [AdminUsersController::class, 'active'])->name('users.active');

    Route::delete('/users/{user}/delete', [AdminUsersController::class, 'delete'])->name('users.delete');

    

    //------------------------------------admin users classified

    Route::match(['get', 'post'], '/all_users_classifieds_admin', [AdminUsersController::class, 'get_all_clasified_users'])->name('all_users_classifieds_admin');

    
    //----------------------------------sliders--------------------------
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::match(['get', 'post'], '/all_sliders', [SliderController::class, 'index'])->name('all_sliders');

        Route::get('/add/slider', [SliderController::class, 'add'])->name('add_slider');

        Route::post('/store/slider', [SliderController::class, 'store'])->name('store_slider');

        Route::get('/edit/slider/{property}', [SliderController::class, 'edit'])->name('edit_slider');

        Route::post('/update/slider/{property}', [SliderController::class, 'update'])->name('update_slider');
        // Route::get('/slider-click/{id}', [SliderController::class, 'incrementViewCount'])->name('slider.click');

        Route::get('/statistique/slider/{id}', [StatistiqueController::class, 'slider_ip'])->name('slider_ip');

        Route::delete('/slider/{id}', [SliderController::class, 'delete'])->name('delete_slider');
    });
    //-----------------------ads--------------------------------
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::match(['get', 'post'], '/all_ads', [AdsController::class, 'index'])->name('all_ads');
        Route::get('/add/ad', [AdsController::class, 'add'])->name('add_ad');
        Route::post('/store/ad', [AdsController::class, 'store'])->name('store_ad');
        Route::get('/edit/ad/{ad}', [AdsController::class, 'edit'])->name('edit_ad');
        Route::post('/update/ad/{ad}', [AdsController::class, 'update'])->name('update_ad');

        Route::get('/statistique/ads/{id}', [StatistiqueController::class, 'ads_ip'])->name('ads_ip');

        Route::delete('/ads/{id}', [AdsController::class, 'delete'])->name('delete_ads');
        // new
        Route::resource("partenaires",PartenaireController::class);

        Route::get("satistique/admin/user/{id}/{userType}",[StatistiqueAdminController::class, 'statUser'])->name('stat.user.index');

        Route::get("satistique/user/mail/{id}",[StatistiqueAdminController::class, 'send_mail_ip'])->name('stat.user.mail');

        Route::get("satistique/user/call/{id}",[StatistiqueAdminController::class, 'call_number_ip'])->name('stat.user.call');

        Route::get("satistique/user/display_number/{id}",[StatistiqueAdminController::class, 'display_number_ip'])->name('stat.user.display_number');
    });
    //--------------------admin Storess------------
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::match(['get', 'post'], '/stores', [AdminStoreController::class, 'index'])->name('stores');
        Route::post('/admin_active_store/{store}', [AdminStoreController::class, 'active'])->name('active.store');

        Route::post('/admin_inactive_store/{store}', [AdminStoreController::class, 'inactive'])->name('inactive.store');
    });
    //-----------------------properties premium--------------------------------
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::match(['get', 'post'], '/all_properties_premium', [PropertyPremiumController::class, 'index'])->name('all_properties_premium');

        Route::post('/update/premium/{id}', [PropertyPremiumController::class, 'store'])->name('store_premium');

        Route::delete('/property-features/{id}', [PropertyPremiumController::class, 'destroy'])->name('property-features.destroy');

    });
});

Route::middleware('auth')->group(function () {
    Route::post('/favorites/{favoritableType}/{favoritableId}', [FavoriteController::class, 'store'])->name('favorites.store');

    Route::delete('/favorites/{favoritableType}/{favoritableId}', [FavoriteController::class, 'destroy'])->name('favorites.destroy');

    Route::get('/favories', [FavoriteController::class, 'index'])->name('user_favories');

    Route::post('/annonce/remonte/{annonceId}', [RemontreController::class, 'remonter'])->name('annonces.remonter');


    Route::get('/statistique/displayed_number', [StatistiqueController::class, 'display_number_ip'])->name('display_number_ip');

    Route::get('/statistique/call_number', [StatistiqueController::class, 'call_number_ip'])->name('call_number_ip');

    Route::get('/statistique/send_email', [StatistiqueController::class, 'send_mail_ip'])->name('send_email_ip');



    
});


Route::post('/slider-click', [SliderController::class, 'incrementViewCount'])->name('slider.click');

Route::get('/ad-click/{id}', [AdsController::class, 'incrementViewCount'])->name('ad.click');



Route::get('/service/info/{service}', [AnnonceServiceController::class, 'get_service_info'])->name('service_info_front');

Route::match(['get', 'post'], "/services", [AnnonceServiceController::class, 'index_front'])->name("index_service_front");

Route::group(['middleware' => ['auth.service_user']], function () {

    Route::get('/service_user_dashboard', [ServiceUserController::class, 'dashboard'])->name('service_user_dashboard');

    Route::get('/service_user_profil', [ServiceUserController::class, 'get_profil'])->name('service_user_profil');
});



//------------------------------------admin users service

Route::match(['get', 'post'], '/all_users_services_admin', [AdminUsersController::class, 'get_all_services_users'])->name('all_users_services_admin');

Route::group(['middleware' => ['auth']], function () {

    Route::get('/service_admin', [AdminServiceController::class, 'index'])->name('admin_services');

    Route::get('/admin_service_info/{id}', [AdminServiceController::class, 'get_service_info'])->name('services.admin.info');

    Route::put('/service_update_status/{id}', [AdminServiceController::class, 'updateStatusService'])->name('service.update.status');


    Route::delete('/service_admin_delete/{id}', [AdminServiceController::class, 'destroy'])->name('services.destroy.admin');

    Route::delete('/users/{user}/service/delete', [AdminUsersController::class, 'deleteUserService'])->name('users.service.delete');


    //admin edit service
    Route::get('/admin_service_update/{service}', [AdminServiceController::class, 'showUpdate'])->name('admin_update_service');

    Route::put('/adminservice_update/{id}', [AdminServiceController::class, 'update'])->name('service_update_admin');

    Route::get('/admin_service_user_add_images/{service}', [AdminServiceController::class, 'showAddImages'])->name('admin_show_add_images_service');

    Route::post('/admin_service_update_images/{service}', [AdminServiceController::class, 'AddImages'])->name('admin_add_images_service');

    //admin edit classified
Route::get('/classified_admin_add', [AdminClassifiedController::class, 'showAdd'])->name('show_Admin_add');
    Route::post('/classified_admin_store', [AdminClassifiedController::class, 'store'])->name('admin_store_classified2');

    Route::get('/classified_admin_add_images/{classified}', [AdminClassifiedController::class, 'showAddImages'])->name('admin_show_add_images');
    Route::get('/admin_classified_update/{classified}', [AdminClassifiedController::class, 'showUpdate'])->name('admin_update_classified');

    Route::get('/admin_classified_user_update_images/{classified}', [AdminClassifiedController::class, 'showUpdateImages'])->name('admin_show_update_images');


    Route::put('/admin_classifieds_update/{id}', [AdminClassifiedController::class, 'update'])->name('admin_classifieds.update');

    Route::post('/admin_classified_update_images/{classified}', [AdminClassifiedController::class, 'AddImages'])->name('admin_add_images_classified');

    Route::delete('/admin-delete-image-classified/{id}', [AdminClassifiedController::class, 'deleteImage'])->name('admin_delete_image_classified');


    //disable active delete user classified and service

    Route::post('/users_classified_service/{user}/disable', [AdminUsersController::class, 'disableServiceClassified'])->name('users_service_classified.disable');

    Route::post('/users_classified_service/{user}/active', [AdminUsersController::class, 'activeServiceClassified'])->name('users_service_classified.active');

    Route::delete('/users_classified_service/{user}/delete', [AdminUsersController::class, 'deleteServiceClassified'])->name('users_service_classified.delete');


    Route::post('/users_access_public/{user}/access', [AdminUsersController::class, 'access_to_publish'])->name('users_give_access');
});

//------------------------------------Service Web-------------------
Route::prefix('admin')->name('admin.')->group(function () {
    Route::match(['get', 'post'], '/all_service_web', [ServiceWebController::class, 'index'])->name('all_service_web');
        Route::get('/add/service_web', [ServiceWebController::class, 'add'])->name('add_service_web');
        Route::post('/store/service_web', [ServiceWebController::class, 'store'])->name('store_service_web');
        Route::get('/edit/service_web/{ad}', [ServiceWebController::class, 'edit'])->name('edit_service_web');
        Route::post('/update/service_web/{ad}', [ServiceWebController::class, 'update'])->name('update_service_web');

        Route::delete('/service_web/{id}', [ServiceWebController::class, 'delete'])->name('delete_service_web');
});