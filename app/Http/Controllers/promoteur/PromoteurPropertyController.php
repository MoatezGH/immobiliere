<?php

namespace App\Http\Controllers\promoteur;

use App\Models\Ad;
use App\Models\Area;
use App\Models\City;
use App\Models\Logo;
use App\Models\Slider;
use App\Models\Category;
use App\Models\Operation;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\PromoteurProperty;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;
use App\Models\PromoteurPropertyImage;



class PromoteurPropertyController extends Controller
{

    public function delete(PromoteurProperty $property)
    {

        try {


            $user = auth()->user();
            $error_message = "Annonce non suprimer";

            $test = $this->checkUser($property, $error_message);

            if ($property->user_id != $user->id) {

                return redirect()->back()->withErrors(['propertyError' => 'Annonce non suprimer']);
            }

            foreach ($property->images as $picture) {
                $picturePath = public_path('uploads/promoteur_property/' . $picture->title);
                if (file_exists($picturePath)) {
                    unlink($picturePath);
                }
                $picture->delete(); // Delete picture record from database
            }

            $property->delete();



            return redirect()->back()->with('success', 'Annonce suprimer avec success');
        } catch (\Throwable $th) {
            return redirect()->back();
        }
    }

    private function getCount()
    {
        // Get the count of all records in the properties table
        $count = PromoteurProperty::count();

        return $count;
    }
    private function getRef($cat)
    {
        // Get the count of all records in the properties table
        $category = Category::find($cat);
        //$count = $this->getCount() + 1;

        // dd($category->alias . $count);
        //$timestamp = date('YmdHis');
$timestamp = "_az". rand(1,999999999);
        $ref = $category->alias . $timestamp;
        // dd($ref);
        return $ref;
    }
    public function store(Request $request)
    {
        // dd($request->all());
        // remise_des_clés
        try {

            $ref = $this->getRef($request->category_id);
            // Create new property
            $property = new PromoteurProperty();
            $property->user_id = auth()->user()->id;
            // $property->token = $request->_token;
            $property->ref = $ref; //oui
            $property->title = $request->title;
            $property->slug = Str::slug($request->title . random_int(3, 9999)); //oui
            $property->description = $request->description;
            $property->operation_id = $request->operation_id;
            $property->category_id = $request->category_id;
            $property->remise_des_clés = $request->remise_des_clés ?? "";
            // price
            $property->price_total = $request->prixtotaol;
            $property->price_metre = $request->pricem²;
            $property->price_metre_terrasse = $request->pricem²_terass;
            $property->price_metre_jardin = $request->pricem²_garden;
            $property->price_cellier = $request->price_cellier;
            $property->price_parking = $request->price_parking;
            //surface
            $property->surface_totale = $request->surface_total;
            $property->surface_habitable = $request->surface_habitable;
            $property->surface_terrasse = $request->surface_terrasse;
            $property->surface_jardin = $request->surface_jardin;
            $property->surface_cellier = $request->surface_cellier;
            //locatioin
            $property->city_id = $request->city_id;
            $property->area_id = $request->area_id;
            $property->address = $request->address;
            // $property->code = $request->code;
            $property->nb_bedroom = $request->room_number;
            $property->nb_living = $request->living_room_number; //oui
            $property->nb_bathroom = $request->bath_room_number;
            $property->nb_kitchen = $request->kitchen_number;
            $property->nb_terrasse = $request->teras_number;
            $property->nb_etage = $request->etage;
            $property->status = 0;


            $property->salle_eau = $request->sal_eau_number;
            $property->suite_parental = $request->suite_parental;
            $property->split = $request->split;
            $property->swimming_pool_public = $request->swimming_pool_public;
            $property->publish_now = isset($request->publish_now) ? $request->publish_now : 0;
            $property->display_price = isset($request->show_price) ? $request->show_price : 0;
            $property->balcon = isset($request->balcon) ? $request->balcon : 0;
            $property->garden = isset($request->garden) ? $request->garden : 0;
            $property->garage = isset($request->garage) ? $request->garage : 0;
            $property->parking = isset($request->parking) ? $request->parking : 0;
            $property->ascenseur = isset($request->elevator) ? $request->elevator : 0;
            $property->heating = isset($request->heating) ? $request->heating : 0;
            $property->climatisation = isset($request->air_conditioner) ? $request->air_conditioner : 0;
            $property->system_alarm = isset($request->alarm_system) ? $request->alarm_system : 0;
            $property->wifi = isset($request->wifi) ? $request->wifi : 0;
            $property->piscine = isset($request->swimming_pool) ? $request->swimming_pool : 0;

            $property->swimming_pool_public = isset($request->swimming_pool_public) ? $request->swimming_pool_public : 0;
            $property->active = isset($request->publish_now) ? $request->publish_now : 0;
            $property->synced = $request->synced ;
            // dd($property);
            $property->save();

            // dispatch(function () use ($request, $property) {
            try {
                $this->updateMainPicture($request, $property);
            } catch (\Exception $e) {
                return redirect()->back()->withErrors(['propertyError' => 'Une erreur s\'est produite lors de l\'ajouter de la photo principale.']);
            }

            try {
                $this->updatePropertyImages($request, $property);
            } catch (\Exception $e) {
                return redirect()->back()->withErrors(['propertyError' => 'Une erreur s\'est produite lors de l\'ajouter des images de la propriété.']);
            }

            try {
                $this->updateMainVideo($request, $property);
            } catch (\Exception $e) {
                return redirect()->back()->withErrors(['propertyError' => 'Une erreur s\'est produite lors de l\'ajouter de la vidéo principale.']);
            }
            // });


            return redirect()->back()->with('success', 'Annonce crée avec succés.');
        } catch (\Exception $e) {
            // dd($e);
            return redirect()->back()->withErrors(['propertyError' => 'Une erreur s\'est produite lors de l\'ajout de votre annonce ']);
        }
    }


    public function get_promoteur_properties(Request $request)
    {

        $user = auth()->user();

        $userAccount = auth()->user()->checkType();
        switch ($userAccount) {
            case 'company':
                $userType = auth()->user()->company;

                break;
            case 'particular':
                $userType = auth()->user()->particular;

                break;

            default:
                $userType = auth()->user()->promoteur;

                break;
        }

        $logo = Logo::find($userType->logo_id);

        // $props = Property::where("user_id", $user->id)->orderBy("created_at", 'desc')->paginate(7);
        $searchTerm = $request->input('keywords');

        // dd($searchTerm);

        // Build the query with optional title filtering
        $query = PromoteurProperty::where('user_id', $user->id);

        if ($searchTerm) {
            $query = $query->where('title', 'like', "%{$searchTerm}%");
        }
        // $ads=Ad::where('active',1)->get();
        // dd($query);
        // Order and paginate the results
        $props = $query->orderBy('created_at', 'desc')
        ->orderBy('updated_at', 'desc')->paginate(7);
        ///


        return view("dasboard_users.properties.all_props_user", compact("props", "logo", "userAccount", "searchTerm"));
    }


    public function EditProperty($slug)
    {
        $property = PromoteurProperty::where('slug', $slug)->get();
        // dd($property[0]);

        if (!$property) {
            return redirect()->back()->withErrors(['propertyError' => 'annonces introuvables ']);
        }
        // dd($property[0]);
        $error_message = "accès refusé";
        $this->checkUser($property[0], $error_message);

        // return view("dasboard_users.properties.edit", compact("property"));

        $userAccount = auth()->user()->checkType();
        // dd($userType);

        switch ($userAccount) {
            case 'company':
                $user = auth()->user()->company;

                break;
            case 'particular':
                $user = auth()->user()->particular;

                break;

            default:
                $user = auth()->user()->promoteur;

                break;
        }

        // $logo = Logo::find($user->logo_id);
        $logo = null;
        if (auth()->user()->store) {
            $logo = auth()->user()->store->logo;
        }
        $operations = Operation::all();
        $categories = Category::all();
        $cities = City::all();
        $areas = Area::where("city_id", $property[0]['city_id'])->get();


        return view('dasboard_users.properties.promoteur.edit', compact('logo', 'operations', 'categories', 'cities', 'userAccount', "property", "areas"));
    }




    public function update(Request $request, PromoteurProperty $property)
    {
        //  dd($request->all());
        try {
            // $property = PromoteurProperty::findOrFail($id);
            // dd($property);
            $error_message = "accès refusé";
            $this->checkUser($property, $error_message);
            // Update property details
            $property->title = $request->title;
            $property->slug = Str::slug($request->title . random_int(3, 9999)); //oui
            $property->description = $request->description;
            $property->operation_id = $request->operation_id;
            $property->category_id = $request->category_id;
            $property->remise_des_clés = $request->remise_des_clés;
            // price
            $property->price_total = $request->prixtotaol;
            $property->price_metre = $request->pricem²;
            $property->price_metre_terrasse = $request->pricem²_terass;
            $property->price_metre_jardin = $request->pricem²_garden;
            $property->price_cellier = $request->price_cellier;
            $property->price_parking = $request->price_parking;
            //surface
            $property->surface_totale = $request->surface_total;
            $property->surface_habitable = $request->surface_habitable;
            $property->surface_terrasse = $request->surface_terrasse;
            $property->surface_jardin = $request->surface_jardin;
            $property->surface_cellier = $request->surface_cellier;
            //locatioin
            $property->city_id = $request->city_id;
            $property->area_id = $request->area_id;
            $property->address = $request->address;
            // $property->code = $request->code;
            $property->nb_bedroom = $request->room_number;
            $property->nb_living = $request->living_room_number; //oui
            $property->nb_bathroom = $request->bath_room_number;
            $property->nb_kitchen = $request->kitchen_number;
            $property->nb_terrasse = $request->teras_number;
            $property->nb_etage = $request->etage;
            $property->status = 0;

            $property->salle_eau = $request->sal_eau_number;

            $property->suite_parental = $request->suite_parental;

            $property->split = $request->split;
            $property->swimming_pool_public = $request->swimming_pool_public;

            $property->publish_now
                = isset($request->publish_now) ? $request->publish_now : 0;
            $property->display_price = isset($request->$request->show_price) ? $request->$request->show_price : 0;


            $property->balcon = isset($request->balcon) ? $request->balcon : 0;
            $property->garden = isset($request->garden) ? $request->garden : 0;
            $property->garage = isset($request->garage) ? $request->garage : 0;
            $property->parking = isset($request->parking) ? $request->parking : 0;
            $property->ascenseur = isset($request->elevator) ? $request->elevator : 0;
            $property->heating = isset($request->heating) ? $request->heating : 0;
            $property->climatisation = isset($request->air_conditioner) ? $request->air_conditioner : 0;
            $property->system_alarm = isset($request->alarm_system) ? $request->alarm_system : 0;
            $property->wifi = isset($request->wifi) ? $request->wifi : 0;
            $property->piscine = isset($request->swimming_pool) ? $request->swimming_pool : 0;
            $property->swimming_pool_public = isset($request->swimming_pool_public) ? $request->swimming_pool_public : 0;
            $property->active =
                isset($request->$request->publish_now) ? $request->$request->publish_now : 0;
            // dd($property->slug);
            // Check if it's mobile or PC and set dimensions accordingly
            $property->save();

            // Rest of your code for updating property details...
            try {
                $this->updateMainPicture($request, $property);
            } catch (\Exception $e) {
                return redirect()->back()->withErrors(['propertyError' => 'Une erreur s\'est produite lors de la mise à jour de la photo principale.']);
            }

            try {
                $this->updatePropertyImages($request, $property);
            } catch (\Exception $e) {
                return redirect()->back()->withErrors(['propertyError' => 'Une erreur s\'est produite lors de la mise à jour des images de la propriété.']);
            }

            try {
                $this->updateMainVideo($request, $property);
            } catch (\Exception $e) {
                return redirect()->back()->withErrors(['propertyError' => 'Une erreur s\'est produite lors de la mise à jour de la vidéo principale.']);
            }


            return redirect()->route('EditPropertyPromoteur', $property->slug)->with('success', 'Annonce mise à jour avec succès.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['propertyError' => 'Une erreur s\'est produite lors de la mise à jour de votre annonce ']);
        }
    }

    private function checkUser($property, $error_message)
    {
        // dd($property);
        $user = auth()->user()->id;
        // dd($user);
        if ($property->user_id != $user) {
            return redirect()->back()->withErrors(['propertyError' => $error_message]);
        };
    }

    private function firstMainPicture($property)
    {
        $main_picture = $property->images()->first();
        $main_picture->update([
            "is_main" => true
        ]);
    }


    function get_all_properties_promoteur_front(Request $request)
    {
        try {
            // dd($request->all());
            $categories = Category::all();
            $cities = City::all();
            $areas=array();
            $ads=Ad::where('active',1)->get();
            $sliders = Slider::all();
            $operations = Operation::all();
            // $query = PromoteurProperty::where('statut', 0);

            // $props = PromoteurProperty::orderBy('created_at', 'desc')->paginate(12);
            $query = PromoteurProperty::where('status', 1);
            // dd($props);
            if ($request->filled('reference')) {
                // dd('test');
                $searchTerm = $request->input('reference');
                $query->where(function ($query) use ($searchTerm) {
                    $query->where('ref', 'like', "%$searchTerm%")
                        ->orWhere('title', 'like', "%$searchTerm%");
                });
            }

            if ($request->filled('operation_id')) {


                $query->where('operation_id', $request->input('operation_id'));
            }

            if ($request->filled('category_id')) {
                $query->where('category_id', $request->input('category_id'));
            }

            if ($request->filled('city_id')) {
                $query->where('city_id', $request->input('city_id'));
                $areas=Area::where("city_id",$request->input('city_id'))->get();
            }

            if ($request->filled('area_id')) {
                $query->where('area_id', $request->input('area_id'));
            }
            if ($request->filled('min_price') || $request->filled('max_price')) {

                $minPrice = $request->input('min_price');
                if ($minPrice == null) $minPrice = "0";

                $maxPrice = $request->input('max_price');
                if ($maxPrice == null) $maxPrice = "0";

                $query->whereBetween('price_total', [$minPrice, $maxPrice]);
            }
            
            $props = $query->orderBy('remonter', 'desc')
            ->orderBy('updated_at', 'desc')->paginate(12);
            


            return view('properties.promoteur.index', compact('props', 'categories', 'cities', 'operations','areas','ads',"sliders"));
        } catch (\Throwable $th) {
            return redirect()->back();
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

    public function deleteImage($id)
    {
        //dd($id);

        try {

            $picture = PromoteurPropertyImage::findOrFail($id);
            
            // You might want to add some error handling here
            if (file_exists(public_path('uploads/promoteur_property/' . $picture->title))) {
                unlink(public_path('uploads/promoteur_property/' . $picture->title));
            }

            // Delete the picture from the database
            $picture->delete();

            // Redirect back with a success message
            // return redirect()->back()->with('success', 'Image supprimée avec succès');
            return response()->json(['success' => 'Photo Deleted Successfully!']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }
}
