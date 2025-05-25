<?php

namespace App\Http\Controllers\Admin\property_premium;

use App\Models\Service;
use App\Models\Property;
use App\Models\Classified;
use Illuminate\Http\Request;
use App\Models\PromoteurProperty;
use App\Models\Property_features;
use App\Http\Controllers\Controller;

class PropertyPremiumController extends Controller
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
    public function index(Request $request)
    {
        try {
            $type=$request->type;
            // dd($type);
            if($type=="ep"){
            $properties = Property_features::where("type__","property")->paginate(12);

            }elseif($type=="p"){
                $properties = Property_features::where("type__","promoteur_property")->paginate(12);
            }elseif($type=="c"){
                $properties = Property_features::where("type__","classified")->paginate(12);
            }elseif($type=="s"){
                $properties = Property_features::where("type__","service")->paginate(12);
            }else{
            // dd("e");

                $properties = Property_features::paginate(12);

            }
            // dd($properties);
            return view("dashboard_admin.property_premium.index", compact("properties"));
        } catch (\Throwable $e) {
            return redirect()->back();
        }
    }

    public function store(Request $request, $id)
    {
        try {
            $type = $request->type;
            if ($type == "property") {
                $property = Property::find($id);
                if ($property->state !== "valid") {  // assuming 'active' is the status you're checking for
                    return redirect()->back()->withErrors("L'annonce n'est pas active.");
                }
            } elseif ($type == "promoteur_property") {
                $property = PromoteurProperty::find($id);
                if ($property->status !== 1) {  // assuming 'active' is the status you're checking for
                // dd("ee");

                    return redirect()->back()->withErrors("L'annonce n'est pas active.");
                }
            }elseif ($type == "classified") {
                $property = Classified::find($id);
                if ($property->status !== 1) {  // assuming 'active' is the status you're checking for
                    return redirect()->back()->withErrors("L'annonce n'est pas active.");
                }
            }elseif ($type == "service") {
                $property = Service::find($id);
                if ($property->status !== 1) {  // assuming 'active' is the status you're checking for
                    return redirect()->back()->withErrors("L'annonce n'est pas active.");
                }
            }
            if (!$property) {
                return redirect()->back()->withErrors("Annonce introuvable.");
            }
            $existingFeature = Property_features::where('property_id', $property->id)
                ->where('type__', $type)
                ->first();

            if ($existingFeature) {
                return redirect()->back()->withErrors("Cette annonce est déjà ajoutée en premium.");
            }
            // dd($property);
            $property_premium = new Property_features();
            // dd($property_premium);

            $property_premium->property_id = $property->id;
            $property_premium->type__ = $type;
            $property_premium->save();
            // dd($property_premium);
            return redirect()->back()->with("success", "Votre annonce a été ajoutée avec succès en premium");
        } catch (\Throwable $e) {
            return redirect()->back();
        }
    }


    public function destroy($id)
    {
        try {
            $property_feature = Property_features::find($id);
            // dd($property_feature);

            if (!$property_feature) {
                return redirect()->back()->withErrors("Annonce introuvable.");
            }

            $property_feature->delete();

            return redirect()->back()->with("success", "Annonce premium supprimé avec succès.");
        } catch (\Throwable $e) {
            return redirect()->back();
        }
    }
}
