<?php

namespace App\Http\Controllers\Admin;

use App\Models\Ad;
use App\Models\Area;
use App\Models\City;
use App\Models\Logo;
use App\Models\User;
use App\Models\Slider;
use App\Models\Service;
use App\Models\Category;
use App\Models\Property;
use App\Models\Operation;
use App\Models\Situation;
use App\Models\Classified;
use Hamcrest\Core\IsEqual;
use App\Models\MainPicture;
use App\Models\ServiceUser;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\ClassifiedUser;
use App\Models\PromoteurProperty;
use App\Models\Property_features;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;
use App\Http\Requests\PropertyRequest;
use LaravelDaily\LaravelCharts\Classes\LaravelChart;

class AdminController extends Controller
{

    public function __construct(){
        try {
            $this->middleware(function($request,$next){
                if(auth()->check() && auth()->user()->is_admin==1){
                    return $next($request);
                }
                return redirect('/');

            });
        } catch (\Throwable $e) {
            redirect()->back();
        }
    }

    public function dashboard()
    {
        $property_promoteur = PromoteurProperty::count();
        $users = User::count();
        $classifiedusers = ClassifiedUser::count();
        $serviceusers = ServiceUser::count();

        $all_services = Service::count();
        $all_classified = Classified::count();





        $query = Property::query();

        $property_company
            = $query->whereHas('user', function ($query) {
                $query->where('is_admin', 0)
                    ->where('is_promoteur', 0)
                    ->where('company_id', '!=', 0)
                    ->whereNotNull('company_id');
            })->count();
            $query = Property::query();

        $property_particulier = $query
            ->whereHas('user', function ($query) {
                $query->where('is_admin', 0)
                    ->where('is_promoteur', 0)
                    ->where('particular_id', '!=', 0)
                    ->whereNotNull('particular_id');
            })->count();
            // dd($property_particulier->toSql());
            // ->count();
            $sliders=Slider::where('active',1)->count();
            $ads=Ad::where('active',1)->count();

        // dd($property_particulier);
            $property_pending=Property::where('state', "waiting")->count();

 //dd($property_pending);
            $property_promoteur_pending=PromoteurProperty::where('status', 0)->count();

            $service_pending = Service::where('status', 0)->count();
            $classified_pending = Classified::where('status', 0)->count();



                //                 $chart_options = [
//                     'chart_title' => 'Utilisateurs par mois',
//                     'report_type' => 'group_by_date',
//                     'model' => 'App\Models\User',
//                     'group_by_field' => 'created_at',
//                     'group_by_period' => 'month',
//                     'chart_type' => 'line',
//                     'filter_field' => 'created_at', // Specify the filter field
//                     'filter_from' => '2022-01-01',  // Filter data starting from 2022
//                 ];


// //                 
//                 $chart1 = new LaravelChart($chart_options);


//                 // $chart3 = new LaravelChart($chart_options3);



//     $chart_options2 = [
//         'chart_title' => 'Users by names',
//         'report_type' => 'group_by_relationship',
//         'model' => 'App\Models\Property',
//         // 'group_by_field' => 'state',
        
//         'relationship_name' => 'city', // represents function user() on Transaction model
//     'group_by_field' => 'name', 
//         'chart_type' => 'pie',
//         'filter_field' => 'created_at',
//         // 'group_by_transformer' => function($value) {
//         //     return $value === 'valid' ? 'Accepte' : ($value === 'waiting' ? 'En attente' : $value);
//         // },
//     ];
//     $chart2 = new LaravelChart($chart_options2);


        return view("dashboard_admin.index", compact('property_particulier', 'property_company', 'property_promoteur', 'users','sliders','ads',"property_pending","property_promoteur_pending",'serviceusers','classifiedusers', 'service_pending', 'classified_pending','all_classified','all_services'));
    }


    public function get_all_property_promoteur(Request $request)
    {
        try {
            $users = User::where('enabled', 1)
            ->where('is_admin', 0)
            ->where('is_promoteur', 1)
            ->with('promoteur')
            ->paginate(10);
        $categories = Category::all();

        // dd($users);
        $query = PromoteurProperty::query();

        // Filter by status if provided
        if ($request->filled('status')) {
            if ($request->input('status') == "valid") {
                $status = 1;
            } else {
                $status = 0;
            }
            $query->where('status', $status);
        }

        // Filter by created_at range if provided
        if ($request->filled('created_at')) {
            $created_at = $request->input('created_at');

            // Convert the provided date to the start and end of the day
            $startOfDay = date('Y-m-d 00:00:00', strtotime($created_at));
            $endOfDay = date('Y-m-d 23:59:59', strtotime($created_at));

            // Apply filter for the entire day
            $query->where('created_at', '>=', $startOfDay)
                ->where('created_at', '<=', $endOfDay);
        }

        // Filter by category_id if provided
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->input('category_id'));
        }
        // Filter by user name if provided
        if ($request->filled('user_name')) {
            $userName = $request->input('user_name');
            $query->whereHas('user', function ($query) use ($userName) {
                $query->where(
                    'username',
                    'like',
                    '%' . $userName . '%'
                );
            });
        }

        $props = $query->orderBy('created_at', 'desc')->paginate(10);
        // dd($props);
        // die("e2");

        $featuresExist = [];
            foreach ($props as $property) {
                $featuresExist[$property->id] = Property_features::where('property_id', $property->id)->exists();
            }
            // dd($featuresExist);
        return view("dashboard_admin.promoteur.index", compact("props", "categories","featuresExist"));
        } catch (\Throwable $e) {
            $e->getMessage();
        }
    }
    function get_prop_prom_info($id)
    {
        // dd('eeee');
        try {
            $property = PromoteurProperty::find($id);
            if (!$property) {
                return redirect()->back();
            }
            // dd($property);
            $user_pro = User::find($property->user_id);
            // dd($user_prop);
            $userAccount = $user_pro->checkType();
            // dd($userAccount);

            switch ($userAccount) {
                case 'company':
                    $user_prop = $user_pro->company;

                    break;
                case 'particular':
                    $user_prop = $user_pro->particular;

                    break;

                default:
                    $user_prop = $user_pro->promoteur;

                    break;
            }
            // dd($user);
            $prop_user_logo = Logo::find($user_prop->logo_id);
            // dd($user_logo);
            $categories = Category::all();

            return view('dashboard_admin.promoteur.info', compact('property', 'user_prop', 'prop_user_logo', 'categories'));
        } catch (\Throwable $th) {
            //throw $th;
        }
    }



    //test sql
    private function getSqlWithBindings($sql, $bindings)
    {
        foreach ($bindings as $binding) {
            $sql = preg_replace('/\?/', "'$binding'", $sql, 1);
        }
        return $sql;
    }
    /**
     * Undocumented function
     *
     * @param Request $request
     * @return void
     */
    public function get_all_property_company(Request $request)
    {
        // dd($request->all());

        $users = User::where('enabled', 1)
            ->where('is_admin', 0)
            ->where('is_promoteur', 0)
            ->where('company_id', '!=', 0)
            ->whereNotNull('company_id')
            ->orderBy('username', 'asc')
            ->get();

        $categories = Category::all();

        $query = Property::query();

        // Filter by user_id if provided
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->input('user_id'));
        }

        // Filter by status if provided
        if ($request->filled('status')) {
            $query->where('state', $request->input('status'));
        }

        // Filter by created_at range if provided
        if ($request->filled('created_at')) {
            $created_at = $request->input('created_at');

            // Convert the provided date to the start and end of the day
            $startOfDay = date('Y-m-d 00:00:00', strtotime($created_at));
            $endOfDay = date('Y-m-d 23:59:59', strtotime($created_at));

            // Apply filter for the entire day
            $query->where('created_at', '>=', $startOfDay)
                ->where('created_at', '<=', $endOfDay);
        }

        // Filter by category_id if provided
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->input('category_id'));
        }
        // Filter by user name if provided
        if ($request->filled('user_name')) {
            $userName = $request->input('user_name');
            $query->whereHas('user', function ($query) use ($userName) {
                $query->where(
                    'username',
                    'like',
                    '%' . $userName . '%'
                );
            });
        }


        $props = $query->whereHas('user', function ($query) {
            $query->where('is_admin', 0)
                ->where('is_promoteur', 0)
                ->where('company_id', '!=', 0)
                ->whereNotNull('company_id');
        })
            ->orderBy('created_at', 'desc')
            ->paginate(10)->appends($request->query());


            $featuresExist = [];
            foreach ($props as $property) {
                $featuresExist[$property->id] = Property_features::where('property_id', $property->id)->exists();
            }
            // dd($featuresExist);
        return view("dashboard_admin.properties.index", compact("props", "users", 'categories','featuresExist'));
    }
    /**
     * Undocumented function
     *
     * @param Request $request
     * @return void
     */
    public function get_all_property_particulier(Request $request)
    {
        // dd($request->all());

        $users = User::where('enabled', 1)
            ->where('is_admin', 0)
            ->where('is_promoteur', 0)
            ->where('particular_id', '!=', 0)
            ->whereNotNull('particular_id')
            ->orderBy('username', 'desc')
            ->get();
        $categories = Category::all();

        $query = Property::query();

        // Filter by user name if provided
        if ($request->filled('user_name')) {
            $userName = $request->input('user_name');
            $query->whereHas('user', function ($query) use ($userName) {
                $query->where(
                    'username',
                    'like',
                    '%' . $userName . '%'
                );
            });
        }

        // Filter by status if provided
        if ($request->filled('status')) {
            $query->where('state', $request->input('status'));
        }

        // Filter by created_at range if provided
        if ($request->filled('created_at')) {
            $created_at = $request->input('created_at');

            // Convert the provided date to the start and end of the day
            $startOfDay = date('Y-m-d 00:00:00', strtotime($created_at));
            $endOfDay = date('Y-m-d 23:59:59', strtotime($created_at));

            // Apply filter for the entire day
            $query->where('created_at', '>=', $startOfDay)
                ->where('created_at', '<=', $endOfDay);
        }

        // Filter by category_id if provided
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->input('category_id'));
        }
        
        $props = $query
            ->whereHas('user', function ($query) {
                $query->where('is_admin', 0)
                    ->where('is_promoteur', 0)
                    ->where('particular_id', '!=', 0)
                    ->whereNotNull('particular_id');
            })
            ->orderBy('created_at', 'desc')
            // ->get();
            ->paginate(10);
        // dd(
        //     $props
        // );
        $featuresExist = [];
        foreach ($props as $property) {
            $featuresExist[$property->id] = Property_features::where('property_id', $property->id)->exists();
        }
        // dd($featuresExist);
        return view("dashboard_admin.properties_particulier.index", compact("props", "users", 'categories','featuresExist'));
    }
    /**
     * Undocumented function
     *
     * @param [type] $id
     * @return void
     */
    function get_prop_info($id)
    {
        // dd('eeee');
        try {
            $property = Property::find($id);
            // dd($property);
            $user_pro = User::find($property->user_id);
            // dd($user_pro);
            $userAccount = $user_pro->checkType();
            // dd($userAccount);

            switch ($userAccount) {
                case 'promoteur':
                    $user_prop = $user_pro->promoteur;


                    break;
                case 'particular':
                    $user_prop = $user_pro->particular;

                    break;

                default:
                    $user_prop = $user_pro->company;

                    break;
            }
            // dd($user);
            // dd($user_prop);

            // $prop_user_logo = Logo::find($user_prop->logo_id);
            $prop_user_logo = null;

            if (!$prop_user_logo) {
                $prop_user_logo = null;
            }
            // dd($prop_user_logo);
            return view('dashboard_admin.properties.info', compact('property', 'user_prop', 'prop_user_logo'));
        } catch (\Throwable $th) {
            return redirect()->back(); //throw $th;
        }
    }


    public function updateStatusProp(Request $request, $id)
    {
        try {
            // Retrieve the property by its ID
            $property = Property::findOrFail($id);
            // dd($property);

            // Validate the request data if needed
            $request->validate([
                'status' => 'required', // Assuming 'status' is the name of your select dropdown
            ], [
                'status.required' => 'Statu obligatoir.', // Custom error message for the 'required' rule
            ]);

            // Update the property status
            $property->state = $request->status;
            $property->save();

            // Redirect back or return a response as needed
            return redirect()->back()->with('success', 'Statut de la propriété mis à jour avec succès.');
        } catch (\Exception $e) {
            // Handle the exception
            return redirect()->back()->with('error', 'Erreur lors de la mise à jour de l\'état de la propriété ');
        }
    }


    public function updateStatusPropPromoteur(Request $request, $id)
    {
        try {
            // Retrieve the property by its ID
            $property = PromoteurProperty::findOrFail($id);
            // dd($request->status);
            if (!$property) {
                return redirect()->back()->with('error', 'Statut de la propriété ne pas modifier.');
            }

            // Validate the request data if needed
            $request->validate([
                'status' => 'required', // Assuming 'status' is the name of your select dropdown
            ], [
                'status.required' => 'Statu obligatoir.', // Custom error message for the 'required' rule
            ]);

            // Update the property status
            $property->status = $request->status;
            $property->save();

            // Redirect back or return a response as needed
            return redirect()->back()->with('success', 'Statut de la propriété mis à jour avec succès.');
        } catch (\Exception $e) {
            // Handle the exception
            return redirect()->back()->with('error', 'Erreur lors de la mise à jour de l\'état de la propriété');
        }
    }


    //edit property
    public function EditProperty($slug)
    {

        try {
            $property = Property::where('slug', 'like', "%{$slug}%")->get();
            // dd(count($property));

            if (count($property) <= 0) {
                return redirect()->back()->withErrors(['propertyError' => 'annonces introuvables ']);
            }

            $operations = Operation::all();
            $categories = Category::all();
            $cities = City::all();
            $areas = Area::where("city_id", $property[0]['city_id'])->get();
            // dd($areas);
            $areasArray = $areas->toArray();
            $situations = Situation::all();


            return view('dashboard_admin.properties.edit', compact('operations', 'categories', 'cities', 'situations', "property", "areas", "areasArray"));
        } catch (\Throwable $e) {
            return redirect()->back()->withErrors(['propertyError' => 'annonces introuvables ']);
        }
    }

    public function EditPropertyPromoteur($slug)
    {

        try {
            $property = PromoteurProperty::where('slug', 'like', "%{$slug}%")->get();
            // dd(count($property));

            if (count($property) <= 0) {
                return redirect()->back()->withErrors(['propertyError' => 'annonces introuvables ']);
            }

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


            return view('dashboard_admin.promoteur.edit', compact('logo', 'operations', 'categories', 'cities', 'userAccount', "property", "areas"));
        } catch (\Throwable $e) {
            return redirect()->back()->withErrors(['propertyError' => 'annonces introuvables ']);
        }
    }

    //update property
    public function updateProperty(PropertyRequest $request, Property $property)
    {
        try {
            // dd($request->all());
            // $error_message = "accès refusé";
            // $this->checkUser($property, $error_message);
            // Assuming user_id shouldn't be updated
            $property->token = $request->_token;
            $property->title = $request->title;
            $property->slug = Str::slug($request->title . random_int(5, 9999));
            $property->description = $request->description;
            $property->operation_id = $request->operation_id;
            $property->category_id = $request->category_id;
            $property->situation_id = $request->situation_id;
            $property->prixtotaol = $request->prixtotaol;
            $property->price = $request->prixtotaol;
            $property->display_price = $request->show_price;
            $property->city_id = $request->city_id;
            $property->area_id = $request->area_id;
            $property->address = $request->address;
            $property->room_number = $request->room_number;
            $property->living_room_number = $request->living_room_number;
            $property->bath_room_number = $request->bath_room_number;
            $property->kitchen_number = $request->kitchen_number;
            $property->terrace = $request->teras_number;
            $property->etage = $request->etage;
            $property->balcony = isset($request->balcon) ? $request->balcon : 0;
            $property->garden = isset($request->garden) ? $request->garden : 0;
            $property->garage = isset($request->garage) ? $request->garage : 0;
            $property->parking = isset($request->parking) ? $request->parking : 0;
            $property->elevator = isset($request->elevator) ? $request->elevator : 0;
            $property->heating = isset($request->heating) ? $request->heating : 0;
            $property->air_conditioner = isset($request->air_conditioner) ? $request->air_conditioner : 0;
            $property->alarm_system = isset($request->alarm_system) ? $request->alarm_system : 0;
            $property->wifi = isset($request->wifi) ? $request->wifi : 0;
            $property->swimming_pool = isset($request->swimming_pool) ? $request->swimming_pool : 0;
            $property->state = "waiting";

            $property->save();

            $this->updateMainPicture($request, $property);

            $this->updatePropertyImages($request, $property);

            $this->updateMainVideo($request, $property);

            // dd('test');
            if ($request->return_url === "company_property") {
                return redirect()->route('all_admin_company_property')->with('success', 'Propriété modifier avec succès');
            }
            return redirect()->route('all_admin_particulier_property')->with('success', 'Propriété modifier avec succès');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['propertyError' => 'Une erreur s\'est produite lors de la modification de votre annonce ']);
        }
    }

    public function updatePropertyPromoteur(Request $request, PromoteurProperty $property)
    {
        // dd($property);
        try {
            // $property = PromoteurProperty::findOrFail($id);
            // dd($property);
            // $error_message = "accès refusé";
            // $this->checkUser($property, $error_message);
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

            $property->publish_now = $request->publish_now ?? 0;
            $property->display_price = $request->show_price;


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
        // dd($property);

            $property->save();

            // Rest of your code for updating property details...
            $this->updateMainPicture($request, $property);


            $this->updatePropertyImages($request, $property);

            $this->updateMainVideo($request, $property);


            return redirect()->route('AdminEditPropertyPromoteur', $property->slug)->with('success', 'Annonce mise à jour avec succès.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['propertyError' => 'Une erreur s\'est produite lors de la mise à jour de votre annonce '.$e->getmessage() ]);
        }
    }


    //delete property
    public function delete(Property $property)
    {
        try {
            $user = auth()->user();

            if ($user->isAdmin()) {
                // Delete associated photos
                foreach ($property->pictures as $photo) {
                    // Delete the photo file from the public directory
                    if (file_exists(public_path('uploads/property_photo/' .$photo->alt))) {
                        unlink(public_path('uploads/property_photo/' .$photo->alt));
                    }
                    // Delete the photo record from the database
                    $photo->delete();
                }

                // Optionally, delete the main picture if it's stored separately
                if ($property->main_picture && file_exists(public_path('/uploads/main_picture/images/properties/'.$property->main_picture->alt))) {
                    unlink(public_path('/uploads/main_picture/images/properties/'.$property->main_picture->alt));
                }

                Property_features::where('property_id', $property->id)
                ->where('type__', 'property')
                ->delete();

                // Finally, delete the property
                $property->delete();

                return redirect()->back()->with('success', 'Annonce supprimée avec succès');
            }

            return redirect()->back()->with('error', 'Vous n\'êtes pas autorisé à supprimer cette annonce');
        } catch (\Throwable $e) {
            // Optionally log the exception if needed
            // Log::error($e);
            return redirect()->back()->with('error', 'Une erreur s\'est produite lors de la suppression de l\'annonce');
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
            $img->save(public_path('uploads/main_picture/images/properties/' . $imgpath));

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
                $img->save(public_path('uploads/property_photo/' . $imgpath));

                // Create a record in the database
                $property->pictures()->create([
                    'alt' =>  $imgpath,
                    'url' => $image->getClientOriginalExtension(),
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
            $video->move(public_path('uploads/videos/properties/'), $videopath);

            // Update the property's video_path with the new video path
            $property->vedio_path = $videopath;
            // dd($property);
            $property->save();
        }
    }


    public function deletePrpertyPromoteur($id)
    {
        // dd("tes");

        try {
            $promoteurproperty = PromoteurProperty::find($id);
            // dd($promoteurproperty);
            // dd($promoteurproperty->property_features);
// dd("eee");
            $user = auth()->user();
            // dd();
            if ($user->isAdmin()) {
                // foreach ($promoteurproperty->property_features as $feature) {

                //     if($feature->type__ !="promoteur_property") continue;
                //     $feature->delete();
                // }
                Property_features::where('property_id', $promoteurproperty->id)
                ->where('type__', 'promoteur_property')
                ->delete();

                $promoteurproperty->delete();

                return redirect()->back()->with('success', 'Annonce suprimer avec success');
            }

            return redirect()->back()->with('error', 'vous n\'êtes pas autorisé de supprimer cette annonce');
        } catch (\Throwable $e) {
            return $e->getMessage();
            return redirect()->back();
        }
    }
}
