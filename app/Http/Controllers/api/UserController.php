<?php

namespace App\Http\Controllers\api;

use App\Models\User;
use App\Models\Store;
use App\Models\Company;
use App\Models\Category;
use App\Models\Property;
use App\Models\Promoteur;
use App\Models\Particular;
use App\Rules\UniqueEmail;
use App\Models\MainPicture;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\PromoteurProperty;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;

use App\Http\Requests\PropertyRequest;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\RequestImmoRegister;


class UserController extends Controller
{
    /**
     * Check if a user exists by email.
     */
    public function checkUser(Request $request)
    {
        try {
            // Validate the request to ensure 'email' is provided
            $request->validate([
                'email' => 'required|email',
            ]);


            // Attempt to find the user by email
            $user = User::where('email', $request->email)->first();

            // If the user exists, return their ID and other relevant info
            if ($user) {


                return response()->json([
                    'index' => $user->id,
                    'email' => $user->email,
                    'exists' => true,
                    'status' => "success",
                ], 200);
            }

            // If the user doesn't exist, return a 404 error
            return response()->json([
                'message' => 'User not found',
                'exists' => false,
                'status' => "success",
            ], 200);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'status' => "error",
                'message' => 'La création de l\'annonce a échoué.',
                'error' => $e->getMessage()
            ], 500);
        }
    }


    /**
     * register user.
     */
    public function register(Request $request)
    {

        try {

            // Validate incoming request data
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'email' => ['required', 'string', 'email', 'max:255', new UniqueEmail],
                'category' => 'required|string|max:255',
                'password' => 'required|string|max:255',



            ]);

            // Check for validation errors
            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'errors' => $validator->errors(),

                ], 422); // 422 Unprocessable Entity for validation errors
            }
            // Create a new user
            $user = User::create([
                'username' => $request->name,
                'email' => $request->email,
                'password' => $request->password,
                'enabled' => 0,
            ]);

            if (!$user) {
                return response()->json(['error' => 'User creation failed'], 500);
            }

            // Handle registration by category
            switch ($request->category) {
                case 'company':
                    $this->registerEntreprise($user, $request);
                    break;

                case 'particular':
                    $this->registerParticular($user, $request);
                    break;

                
                    case 'promoteur':
                        $this->registerPromoteur($user, $request);
                        break;
                default:
                    return response()->json(['error' => 'Invalid category','status'=>'error'], 400);
            }

            // Authenticate the user and generate token
            // $token = Auth::guard()->login($user);

            return response()->json([
                'message' => 'Registration successful',
                'status' => 'success',


                'index' => $user->id
            ], 201);
        } catch (\Exception $e) {
            // Log the error for future debugging
            \Log::error('Registration failed: ' . $e->getMessage());

            // Return a generic error message
            return response()->json(['error' => 'Registration failed:' . $e->getMessage(),'status' => 'error','full_error' => (string)$e], 500);
        }
    }

    /**
     * register Entreprise.
     */
    private function registerEntreprise($user, $request)
    {
        $company = Company::create([
            'user_id' => $user->id,
            'corporate_name' => $request->name,
            'category' => 'Agence immobilière',
        ]);

        if (!$company) {
            throw new Exception('Company creation failed.');
        }

        $store = Store::create([
            'user_id' => $user->id,
            'store_name' => $request->name,
            'store_email' => $request->email,
            'type' => 'company',
            'slug' => Str::slug($request->name . random_int(5, 9999)),
        ]);

        if (!$store) {
            throw new Exception('Store creation failed.');
        }

        $user->update([
            'company_id' => $company->id,
            'store_id' => $store->id,
        ]);
    }


    /**
     * register Particular.
     */
    private function registerParticular($user, $request)
    {
        // Split full name into first and last name
        $nameParts = explode(' ', $request->name);
        $firstName = $nameParts[0];
        $lastName = $nameParts[1] ?? '';

        $particular = Particular::create([
            'user_id' => $user->id,
            'first_name' => $firstName,
            'last_name' => $lastName,
        ]);

        if (!$particular) {
            throw new Exception('Particular creation failed.');
        }

        $store = Store::create([
            'user_id' => $user->id,
            'store_name' => $request->name,
            'store_email' => $request->email,
            'type' => 'particulier',
            'slug' => Str::slug($request->name . random_int(5, 9999)),
        ]);

        if (!$store) {
            throw new Exception('Store creation failed.');
        }

        $user->update([
            'particular_id' => $particular->id,
            'store_id' => $store->id,
        ]);
    }

    /**
     * register Promoteur.
     */
    private function registerPromoteur($user, $request)
    {
        // Split full name into first and last name
        $nameParts = explode(' ', $request->name);
        $firstName = $nameParts[0];
        $lastName = $nameParts[1] ?? null;

        $promoteur = Promoteur::create([
            'user_id' => $user->id,
            'first_name' => $firstName,
            'last_name' => $lastName,
        ]);

        if (!$promoteur) {
            throw new Exception('Promoteur creation failed.');
        }

        $store = Store::create([
            'user_id' => $user->id,
            'store_name' => $request->name,
            'store_email' => $request->email,
            'type' => 'promoteur',
            'slug' => Str::slug($request->name . random_int(5, 9999)),
        ]);

        if (!$store) {
            throw new Exception('Store creation failed.');
        }

        $user->update([
            'promoteur_id' => $promoteur->id,
            'is_promoteur' => 1,
            'store_id' => $store->id,
        ]);
    }

    private function getCount()
    {
        try {
            $count = Property::count();

            return $count;
        } catch (\Exception $e) {
            return response()->json(['error' => 'get count failed:' . $e->getMessage()], 500);
        }
    }

    public function getRef($cat)
    {
        try {
            // Get the count of all records in the properties table
           $category = Category::find($cat);
            // dd($category->alias . $count);
            $timestamp = "_az". rand(1,999999999);
        $ref = $category->alias . $timestamp;

            return $ref;
        } catch (\Throwable $e) {
            return response()->json(['error' => 'get ref failed:' . $e->getMessage()], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            
            $ref = $this->getRef($request->category_id);
            // Create new property
            $property = new Property();
            $property->city_id = $request->city_id;
            $property->area_id = $request->area_id;
            $property->operation_id = $request->operation_id;
            $property->user_id = $request->user_id;
            $property->category_id = $request->category_id;
            $property->ref = $ref;

            $property->token = $request->token;
            $property->title = $request->title;
            $property->slug = Str::slug($request->title . random_int(5, 9999));
            $property->description = $request->description;
            $property->price = $request->prixtotaol;
            $property->display_price = isset($request->display_price) ? $request->display_price : 0;

            $property->situation_id = $request->situation_id;
            $property->prixtotaol = $request->prixtotaol;
            $property->floor_area = $request->floor_area;
            $property->plot_area = $request->plot_area;
            $property->room_number = $request->room_number;
            $property->living_room_number = $request->living_room_number;
            $property->bath_room_number = $request->bath_room_number;
            $property->kitchen_number = $request->kitchen_number;
            $property->balcony = isset($request->balcony) ? $request->balcony : 0;
            $property->terrace = $request->terrace;
            $property->garden = isset($request->garden) ? $request->garden : 0;
            $property->garage = isset($request->garage) ? $request->garage : 0;
            $property->parking = isset($request->parking) ? $request->parking : 0;
            $property->elevator = isset($request->elevator) ? $request->elevator : 0;
            $property->air_conditioner = isset($request->air_conditioner) ? $request->air_conditioner : 0;
            $property->alarm_system = isset($request->alarm_system) ? $request->alarm_system : 0;
            $property->wifi = isset($request->wifi) ? $request->wifi : 0;
            
            $property->active =  isset($request->active) ? $request->active : 0;
            $property->state = $request->state;
            $property->swimming_pool = isset($request->swimming_pool) ? $request->swimming_pool : 0;
            
            $property->address = $request->address;
            
            $property->etage = $request->etage;
            $property->heating = isset($request->heating) ? $request->heating : 0;


            // dd($property);

            $property->save();
            
            $this->updateMainPicture($request, $property);
            $this->updatePropertyImages($request, $property);
            


            return response()->json([
                'success' => true,
                'message' => 'property créée avec succès.',
                'property_id' => $property->id,
                'status' => 'success',

            ], 201);
        } catch (\Exception $e) {
            // dd($e);
            return response()->json([
                'success' => false,
                'message' => 'La création de property a échoué.',
                'error' => $e->getMessage(),
                'status' => 'error',
'full_error' => (string)$e,
            ], 500);
        }
    }




    //main picture
    private function updateMainPicture($request, $property)
    {
        if ($request->hasFile('photos_main')) {
            $image = $request->photos_main;

            $img = Image::make($image);
            $extension = $image->extension();
            $str_random = Str::random(8);
            // $img->resize(729, 398);
            $img->resize(
                520,
                370
            );

            $imgpath = $str_random . time() . "." . $extension;

            // Save the resized image
            $img->save(public_path('uploads/main_picture/images/properties/' . $imgpath), 100);

            // Create a record in the database for the new main picture
            $main_picture = new MainPicture();
            $main_picture->alt = $imgpath;
            $main_picture->url = $image->getClientOriginalExtension();
            $main_picture->save();

            // Update the property's image_id with the ID of the new main picture
            $property->image_id = $main_picture->id;
            $property->save();
        }
    }


    //multi image
    private function updatePropertyImages($request, $property)
    {
        if ($request->hasFile('photos_multiple')) {
            foreach ($request->file('photos_multiple') as $image) {

                $img = Image::make($image);
                $extension = $image->extension();
                $str_random = Str::random(8);
                // $img->resize(729, 398);
                $img->resize(520, 370);

                $imgpath = $str_random . time() . "." . $extension;

                // Save the resized image
                $img->save(public_path('uploads/property_photo/' . $imgpath), 100);

                // Create a record in the database
                $property->pictures()->create([
                    'alt' =>  $imgpath,
                    'url' => $image->getClientOriginalExtension(),
                ]);
            }
        }
    }


    ///promoteur

    public function storePromoteur(Request $request)
    {
        // dd($request->all());
        // remise_des_clés
        try {

            $ref = $this->getRef($request->category_id);
            // Create new property
            $property = new PromoteurProperty();
            $property->user_id = $request->user_id;
            // $property->token = $request->_token;
            $property->ref = $ref; //oui
            $property->title = $request->title;
            $property->slug = Str::slug($request->title . random_int(3, 9999)); //oui
            $property->description = $request->description;
            $property->operation_id = $request->operation_id;
            $property->category_id = $request->category_id;
            $property->remise_des_clés = $request->remise_des_clés ?? "";
            // price
            $property->price_total = $request->price_total;
            $property->price_metre = $request->price_metre;
            $property->price_metre_terrasse = $request->price_metre_terrasse;
            $property->price_metre_jardin = $request->price_metre_jardin;
            $property->price_cellier = $request->price_cellier;
            $property->price_parking = $request->price_parking;
            //surface
            $property->surface_totale = $request->surface_totale;
            $property->surface_habitable = $request->surface_habitable;
            $property->surface_terrasse = $request->surface_terrasse;
            $property->surface_jardin = $request->surface_jardin;
            $property->surface_cellier = $request->surface_cellier;
            //locatioin
            $property->city_id = $request->city_id;
            $property->area_id = $request->area_id;
            $property->address = $request->address;
            // $property->code = $request->code;
            $property->nb_bedroom = $request->nb_bedroom;
            $property->nb_living = $request->nb_living; //oui
            $property->nb_bathroom = $request->nb_bathroom;
            $property->nb_kitchen = $request->nb_kitchen;
            $property->nb_terrasse = $request->nb_terrasse;
            $property->nb_etage = $request->nb_etage;
            $property->status = $request->status;


            $property->salle_eau = $request->salle_eau;
            $property->suite_parental = $request->suite_parental;
            $property->split = $request->split;
            // $property->swimming_pool_public = $request->swimming_pool_public;
            $property->publish_now = isset($request->publish_now) ? $request->publish_now : 0;
            $property->display_price = isset($request->display_price) ? $request->display_price : 0;
            $property->balcon = isset($request->balcon) ? $request->balcon : 0;
            $property->garden = isset($request->garden) ? $request->garden : 0;
            $property->garage = isset($request->garage) ? $request->garage : 0;
            $property->parking = isset($request->parking) ? $request->parking : 0;
            $property->ascenseur = isset($request->ascenseur) ? $request->ascenseur : 0;
            $property->heating = isset($request->heating) ? $request->heating : 0;
            $property->climatisation = isset($request->climatisation) ? $request->climatisation : 0;
            $property->system_alarm = isset($request->system_alarm) ? $request->system_alarm : 0;
            $property->wifi = isset($request->wifi) ? $request->wifi : 0;
            $property->piscine = isset($request->piscine) ? $request->piscine : 0;

            $property->swimming_pool_public = isset($request->swimming_pool_public) ? $request->swimming_pool_public : 0;
            $property->active = isset($request->active) ? $request->active : 0;

            // dd($property);
            $property->save();

            // dispatch(function () use ($request, $property) {
            try {
                $this->updateMainPicturePromoteur($request, $property);
            } catch (\Exception $e) {
                

                return response()->json(['error' => 'Registration failed:' . $e->getMessage(),'status' => 'error',], 500);
            }

            try {
                $this->updatePropertyImagesPromoteur($request, $property);
            } catch (\Exception $e) {
                return response()->json(['error' => 'create property promoteur failed:' . $e->getMessage(),'status' => 'error',], 500);
            }

            try {
                $this->updateMainVideo($request, $property);
            } catch (\Exception $e) {
                return response()->json(['error' => 'create property promoteur failed:' . $e->getMessage(),'status' => 'error',], 500);
            }
            // });


            return response()->json([
                'success' => true,
                'message' => 'property promoteur créée avec succès.',
                'property_promoteur_id' => $property->id,
                'status' => 'success',

            ], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'create property promoteur failed:' . $e->getMessage(),'status' => 'error',], 500);
        }
    }


    //main picture
    private function updateMainPicturePromoteur($request, $property)
    {

        if ($request->hasFile('photos_main')) {
            $image = $request->photos_main;


            $img = Image::make($image);
            $extension = $image->extension();
            $str_random = Str::random(8);
            // $img->resize(729, 398);
            $img->resize(
                520,
                370
            );

            $imgpath = $str_random . time() . "." . $extension;

            // Save the resized image
            // $img->save(public_path('uploads/main_picture/images/properties/' . $imgpath), 100);
            $img->save(public_path('uploads/promoteur_property/' . $imgpath), 100);


            $existingMainImage = $property->images()->where('is_main', 1)->first();
            //dd($existingMainImage);
            if ($existingMainImage) {
                $existingMainImage->is_main = 0;
                $existingMainImage->save();
            }
            // Create a record in the database for the new main picture
            $property->images()->create([
                'title' =>  $imgpath,
                'is_main' => "1",
            ]);
            //dd($tet);
        }
    }


    //multi image
    private function updatePropertyImagesPromoteur($request, $property)
    {

        if ($request->hasFile('photos_multiple')) {
            foreach ($request->file('photos_multiple') as $image) {

                $img = Image::make($image);
                $extension = $image->extension();
                $str_random = Str::random(8);
                // $img->resize(729, 398);
                $img->resize(520, 370);

                $imgpath = $str_random . time() . "." . $extension;

                // Save the resized image
                $img->save(public_path('uploads/promoteur_property/' . $imgpath), 100);

                // Create a record in the database for the new main picture
                $property->images()->create([
                    'title' =>  $imgpath,
                    'is_main' => "0",
                ]);
            }
        }
    }

    private function updateMainVideo($request, $property)
    {
        

        // Check if the request contains a file named 'video'
        if ($request->hasFile('video')) {
            // dd($property);

            $video = $request->file('video');

            // Generate a unique filename
            $extension = $video->getClientOriginalExtension();
            $str_random = Str::random(8);
            $videopath = $str_random . time() . "." . $extension;

            // Save the video file to the desired location
            $video->move(public_path('uploads/videos/properties_promoteur/'), $videopath);

            // Update the property's video_path with the new video path
            $property->vedio_path = $videopath;
            // dd($property);
            $property->save();
        }
    }
}
