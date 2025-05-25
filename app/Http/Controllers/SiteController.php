<?php

namespace App\Http\Controllers;

use App\Models\Ad;

use App\Models\Area;
use App\Models\City;
use App\Models\Logo;
use App\Models\Store;
use App\Models\Slider;
use App\Models\Category;
use App\Models\Property;
use App\Mail\ContactMail;
use App\Models\Operation;
use App\Models\Classified;
use App\Models\Partenaire;
use App\Models\Statistique;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\PromoteurProperty;
use App\Models\Property_features;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Cache;
use App\Models\ServiceWeb;
class SiteController extends Controller
{


    public function index()
    {
        try {
            $properties = Property_features::where("type__","property")->orderBy('created_at', 'desc')->limit(12)->get();
        // dd($properties);
        $properties_prom_pre = Property_features::where("type__","promoteur_property")->orderBy('created_at', 'desc')->paginate(6);
        $classifieds = Property_features::where("type__","classified")->orderBy('created_at', 'desc')->limit(0)->get();

        $services = Property_features::where("type__","service")->orderBy('created_at', 'desc')->limit(6)->get();
        // dd($properties);
        // $promoteur_properties = PromoteurProperty::where('status', 1)->orderBy('created_at', 'asc')->paginate(12);
        // dd($promoteur_properties);

        $storesItems = Store::where(function($query) {
            $query->where('type', 'promoteur')
                  ->orWhere('type', 'company');
        })->where('status', 1)
          ->orderBy('created_at')
          ->limit(20)->get();
        // Store::where('type', 'promoteur')->orWhere('type', 'company')->orderBy('created_at')->paginate(20);
        // dd($storesItems);
        $stores = array();
        foreach ($storesItems as $item) {
            // dd($item->user->enabled);
            if ($item->user->enabled == 1) {
                $stores[] = $item;
            }
        };

        $sliders = Slider::all();

        $cities = City::all();

        $partenaires = Partenaire::where("status",1)->get();
        $logo = new Logo;
        $operation = Operation::all();
        $categories = Category::all();
        // print_r()
        // dd($services);
$serviceWeb = ServiceWeb::where("active",1)->get();

        return view('welcome', compact('properties', 'partenaires', 'storesItems', 'sliders', 'cities', 'operation', 'categories','properties_prom_pre','classifieds','services','serviceWeb'));
        } catch (\Throwable $e) {
            // dd($e->getMessage());:
            return redirect()->back();
        }
        
    }
    /**
     * Undocumented function
     *
     * @param [type] $cityId
     * @return void
     */
    public function get_area_by_id($cityId)
    {
        $aries = Area::where('city_id', $cityId)->get();
        return response()->json($aries);
    }
    

    public function get_all_stores(Request $request)
{
    $categories = Category::all();
    $ads = Ad::where('active', 1)->get();
    $sliders = Slider::all();

    // Build the base query
    $storesQuery = Store::where(function ($query) {
        $query->where('type', 'promoteur')
              ->orWhere('type', 'company');
    })->where('status', 1)
      ->orderBy('created_at');

    // Apply additional filtering if 'type' is provided in the request
    if ($request->filled('type')) {
        $type = $request->type;
        $storesQuery->where('type', $type);
    }

    // Paginate the results
    $stores = $storesQuery->paginate(24);

    return view('stores.index', compact('stores', 'categories', 'ads', 'sliders'));
}

    /**
     * Undocumented function
     *
     * @param Request $request
     * @param [type] $slug
     * @return void
     */
    public function get_store_products(Request $request, $slug)
    {
        $store = Store::where('slug', 'like',$slug)->get();
        //dd($store);
        if (!$store) {
            return redirect()->back();
        }
        //new-------------

        $store[0]->nb_view +=1;
        $store[0]->save();
        // dd();

        $user_type = $store[0]->user->checkType();
        // dd($user_type);
        // if()$property = Property::where('slug', 'like', "%{$slug}%")->get();
        $sliders = Slider::all();
        $ads=Ad::where('active',1)->get();
            

        $categories = Category::all();
        $cities = City::all();
        //new-------------
        $areas=array();
        $operations = Operation::all();
        if ($user_type != "promoteur") {
            $query = Property::where('state', 'valid')->where("user_id", $store[0]->user_id);
            $price='prixtotaol';
        } else {
            $query = PromoteurProperty::where('status', 1)->where("user_id", $store[0]->user_id);
            $price='price_total';

        }
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
        }

        if ($request->filled('area_id')) {
            $query->where('area_id', $request->input('area_id'));
        }
        if ($request->filled('min_price') && $request->filled('max_price')) {
            $minPrice = $request->input('min_price');
            $maxPrice = $request->input('max_price');
            $query->whereBetween($price, [$minPrice, $maxPrice]);
        }
        // dd($query);
        $props = $query->orderBy('created_at', 'desc')->paginate(12);
        // $products = Property::where("user_id", $store->user_id)->where("state","valid");
        return view('stores.info', compact('props', 'categories', 'cities', 'operations', 'store', 'user_type','areas','sliders',"ads"));
    }


    public function sendEmailClient(Request $request)
    {
        // dd($request->all());

        try {
            // Custom validation messages in French
            $messages = [
                'name.required' => 'Le champ nom est obligatoire.',
                'name.string' => 'Le nom doit être une chaîne de caractères.',
                'name.max' => 'Le nom ne doit pas dépasser 255 caractères.',
                'email.required' => 'Le champ email est obligatoire.',
                'email.email' => 'Veuillez fournir une adresse email valide.',
                'email.max' => 'L\'email ne doit pas dépasser 255 caractères.',
                'message.required' => 'Le champ message est obligatoire.',
                'message.string' => 'Le message doit être une chaîne de caractères.',
            ];

            // Validate the request with custom messages
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'message' => 'required|string',
            ], $messages);

            if ($request->type == "property") {
                $property = Property::find($request->property_id);
            } else if ($request->type == "property-promoteur"){
                $property = PromoteurProperty::find($request->property_id);
            }else if ($request->type == "classified"){
                $property = Classified::find($request->property_id);
            }
            if (!$property) {
                return back()->with('error', 'Problem de connexion!');
            }
            //dd($property);
            $property_email = $property->user->email;
            // dd($request->action_type);

            $details = [
                'name' => $request->name,
                'email' => $request->email,
                'message' => $request->message,
                'phone' => $request->phone,

            ];
            //dd($details);

            // $send = 
            Mail::to($property_email)->send(new ContactMail($details));

            //dd($send);

            Statistique::create([
                'user_id' => $property->user_id,
                'action_type' => "mail",
                'ip'=>request()->ip(),
            ]);
            return redirect()->back()->with('success', 'E-mail envoyé avec succès!');
        } catch (\Throwable $e) {
            //dd($e->getMessage());
            return redirect()->back()->with('error', 'Problem de connexion!:'.$e->getMessage());
        }
    }


    function soon()
    {
        return view('coming_soon');
    }
}
