

<style>
    .img-page{
        /* max-height: 800px; */
    width: -webkit-fill-available;
    }
    
</style>
@php
$image = "tes";
switch(Route::current()->getName()) {
    case "dashboard_admin":
        $image = "images_pages_new/dashboard.png";
        break;

        case "dashboard_annonceur_immobilier":
        $image = "images_pages_new/dashboard.png";
        break;

        case "login":
        $image = "images_pages_new/login.png";
        break;

        case "account_type":
        $image = "images_pages_new/login.png";
        break;
        
        case "get_register_immo":
        $image = "images_pages_new/login.png";
        break;

        case "all_user_property":
        $image = "images_pages_new/annonces.jpeg";
        break;

        
        case "all_promoteur_property":
        $image = "images_pages_new/annonces.jpeg";
        break;
        
        
        case "profile_annonceur_immobilier":
        $image = "images_pages_new/profile.png";
        break;
        case "show_profile_service":
        $image = "images_pages_new/profile.png";
        break;


        case "all_admin_company_property":
        $image = "images_pages_new/entreprise.png";
        break;

        case "all_admin_particulier_property":
        $image = "images_pages_new/particulier.png";
        break;

        case "all_admin_property_promoteur":
        $image = "images_pages_new/promoteur.png";
        break;
        

        case "admin.stores":
        $image = "images_pages_new/stores.png";
        break;


        case "all_users_admin":
        $image = "images_pages_new/users.png";
        break;

        case "admin.all_ads":
        $image = "images_pages_new/ads.jpeg";
        break;

        case "admin.all_sliders":
        $image = "images_pages_new/slider.png";
        break;

        case "get_add_property":
        $image = "images_pages_new/add_annonce.jpeg";
        break;

        case "user_favories":
        $image = "images_pages_new/favori.png";
        break;
        case "admin.all_properties_premium":
        $image = "images_pages_new/premium.png";
        break;
        
    default:
        $image = "";
        break;
}
@endphp

<div class="site-breadcrumb" style="padding: 0px;">
    <img src="{{asset("/"). $image }}" alt="" class="img-page">
</div>