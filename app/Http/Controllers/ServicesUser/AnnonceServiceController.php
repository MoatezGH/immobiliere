<?php

namespace App\Http\Controllers\ServicesUser;

use App\Models\Ad;
use App\Models\Area;
use App\Models\City;
use App\Models\Slider;
use App\Models\Service;
use App\Models\ServiceType;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\ServicePicture;
use App\Models\ServiceCategory;
use App\Models\Property_features;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;

class AnnonceServiceController extends Controller
{
    public function index(Request $request)
    {
        try {
            $user = auth()->guard('service_user')->user();

            $query = Service::where('user_id', $user->id);
            // dd($query );

            if ($request->filled('keywords')) {
                $keywords = $request->input('keywords');
        
                $query->where(function ($query) use ($keywords) {
                    $query->where('ref', 'like', '%' . $keywords . '%')
                        ->orWhere('title', 'like', '%' . $keywords . '%');
                });
            }
            $services=$query->orderBy("updated_at", "desc")->paginate(12);
            // $services = Service::where('user_id', $user->id)->orderBy("updated_at", "desc")->paginate(12);
            return view("dashboard_service.annonces.index", compact("services"));
        } catch (\Throwable $e) {
            $e->getMessage();
            return redirect()->back();
        }
    }


    public function showAdd()
    {
        try {
            $categories = ServiceCategory::orderBy("name", "asc")->get();
            $cities = City::all();
            // $areas = Area::all();

            $type_payement = ServiceType::where("type", "payement_type")->get();
            return view("dashboard_service.annonces.add", compact("categories", "cities", "type_payement"));
        } catch (\Throwable $e) {
            // dd($e->getMessage());
            return redirect()->back();
        }
    }

    public function store(Request  $request)
    {
        // dd(uniqid());

        try {
            $slug = Str::slug($request->title) . '-' . uniqid();
            $service = new Service([
                'title' => $request->title,
                'category_id' => $request->categorie_id,
                'service' => $request->service,
                'city_id' => $request->city_id,

                'work_zone' => $request->work_zone,

                'annonceur_type' => $request->type_annonceur,

                'type' => $request->type_product,
                'description' => $request->description ?? "",
                'user_id' => auth()->guard("service_user")->user()->id, // Assuming the user is authenticated
                'ref' => uniqid(), // Generate a unique reference
                'status' => 0, // Default status
                'slug' => $slug,
                'paiement_type' => $request->paiement_type,
                'synced' =>  isset($request->synced) ? true : false
            ]);


            $res = $service->save();

            return redirect()->route('show_add_images_service', ['service' => $service->id])->with('success', 'Annonce créée avec succès.');
        } catch (\Throwable $e) {
            // $e->getMessage();
            return redirect()->back()->with('error', 'La création de service a échoué.');
        }
    }

    public function showAddImages($serviceId)
    {
        // dd($serviceId);
        $service = Service::findOrFail($serviceId);
        return view("dashboard_service.annonces.add_image")->with(["service" => $service]);
    }


    public function AddImages(Request $request, Service $service)
    {
        // dd($request->all());
        try {
            $service->status = 0;

            try {
                $this->updateMainPicture($request, $service);
            } catch (\Exception $e) {
                return redirect()->back()->withErrors(['propertyError' => 'Une erreur s\'est produite lors de la mise à jour de la photo principale.']);
            }

            try {
                $this->updateServiceImages($request, $service);
            } catch (\Exception $e) {
                return redirect()->back()->withErrors(['propertyError' => 'Une erreur s\'est produite lors de la mise à jour des images de la service.']);
            }

            $service->save();

            return redirect()->route('index_service')->with("success", 'Service crée/modifier avec succès');
        } catch (\Throwable $e) {
            // return $e->getMessage();
            return redirect()->back();

        }
    }
    public function showUpdateImages($serviceId)
    {
        try {
            // dd($serviceId);
            $service = Service::findOrFail($serviceId);
            return view("dashboard_service.annonces.edit_image")->with(["service" => $service]);
        } catch (\Throwable $e) {
            return redirect()->back();
        }
    }

    //main picture
    private function updateMainPicture($request, $service)
    {

        if ($request->hasFile('photos_main')) {

            if ($service->mainPicture) {
                $oldPicturePath = public_path('uploads/service/main_picture/' . $service->mainPicture->picture_path);
                if (file_exists($oldPicturePath)) {
                    unlink($oldPicturePath);
                }
                $service->mainPicture->delete();
            }
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
            $img->save(public_path('uploads/service/main_picture/' . $imgpath), 100);


            // $existingMainImage = $property->images()->where('is_main', 1)->first();
            // //dd($existingMainImage);
            // if ($existingMainImage) {
            //     $existingMainImage->is_main = 0;
            //     $existingMainImage->save();
            // }
            // Create a record in the database for the new main picture
            $service->mainPicture()->create([
                'picture_path' =>  $imgpath,
                'service_id' => $service->id,
            ]);

            $service->update([

                'status' => 0,
            ]);
            // dd($service);
        }
    }


    //multi image
    private function updateServiceImages($request, $service)
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
                $img->save(public_path('uploads/service/multi_images/' . $imgpath), 100);

                // Create a record in the database for the new main picture
                $service->pictures()->create([
                    'picture_path' =>  $imgpath,
                    'service_id' => $service->id,
                ]);
            }
        }
    }


    public function deleteImage($id)
    {

        try {
            // Find the picture by ID
            // $user=auth()->guard('classified_user')->user();
            // dd($user);

            $picture = ServicePicture::findOrFail($id);
            // dd($picture);

            if (file_exists(public_path('uploads/service/multi_images/' . $picture->picture_path))) {
                unlink(public_path('uploads/service/multi_images/' . $picture->picture_path));
            }

            // Delete the picture from the database
            $picture->delete();

            // Redirect back with a success message
            // return redirect()->back()->with('success', 'Image supprimée avec succès');
            return response()->json(['success' => 'Photo Deleted Successfully!']);
        } catch (\Throwable $th) {
            return redirect()->back();
        }
    }



    public function showUpdate($serviceId)
    {

        try {
            // dd($serviceId);
            $service = Service::findOrFail($serviceId);

            $categories = ServiceCategory::orderBy("name", "asc")->get();

            $cities = City::all();

            $areas = Area::where("city_id", $service->city_id)->get();

            $type_payement = ServiceType::where("type", "payement_type")->get();


            $categories = serviceCategory::all();

            return view("dashboard_service.annonces.edit", compact("service", "categories", "cities", "areas", "type_payement"));
        } catch (\Throwable $e) {
            return redirect()->back();
        }
    }



    public function update(Request $request, $id)
    {
        try {
            // dd($request->all());
            // Retrieve the existing service
            $service = Service::findOrFail($id);

            // Generate a new slug if the title is updated
            // $slug = Str::slug($request->title) . '-' . uniqid();

            // Update the service properties
            $service->title = $request->title;
            $service->category_id = $request->categorie_id;
            $service->service = $request->service;
            $service->city_id = $request->city_id;
            $service->work_zone = $request->work_zone;
            $service->annonceur_type = $request->type_annonceur;
            $service->type = $request->type_product;
            $service->description = $request->description ?? "";
            // $service->slug = $slug;
            $service->paiement_type = $request->paiement_type;
            if ($service->isDirty('title')) {
                $service->slug = Str::slug($request->title) . '-' . uniqid();
            }
            $service->status = 0;
            // Save the updated service
            $res = $service->save();

            // Redirect to the show_add_images_service route with success message
            return redirect()->route('index_service')->with('success', 'Service mise à jour avec succès.');
        } catch (\Throwable $e) {
            // return $e->getMessage();
            // Handle any errors
            return redirect()->back()->with('error', 'La mise à jour de service a échoué.');
        }
    }


    public function destroy($id)
    {
        try {
            // Find the classified ad by its ID
            $service = Service::findOrFail($id);
            $perimium = Property_features::where('property_id', $service->id)
                ->where('type__', 'service')
                ->first();
            if ($perimium) {
                $perimium->delete();
            }
            if (count($service->pictures) > 0) {
                // dd("ee");
                foreach ($service->pictures as $picture) {


                    if (file_exists(public_path('uploads/service/multi_images/' . $picture->picture_path))) {
                        unlink(public_path('uploads/service/multi_images/' . $picture->picture_path));
                    }

                    // Delete the picture from the database
                    $picture->delete();
                }
            }

            // Delete the service ad
            $service->delete();

            // Redirect or return a response
            return redirect()->route('index_service')->with('success', 'Service supprimée avec succès.');
        } catch (\Throwable $e) {
            // Handle any errors
            // dd($e->getMessage());

            // $e->getMessage();
            return redirect()->back()->with('error', 'La suppression de service a échoué.');
        }
    }


    function get_service_info($slug)
    {
        // dd("ddd");
        try {
            $service = Service::where('slug', $slug)->get();
            // dd($service);
            if (!$service) {
                return redirect()->back();
            }
            $service[0]->incrementViewCount();

            $categories = ServiceCategory::all();


            $ads = Ad::where('active', 1)->get();
            $sliders = Slider::all();

            $type = "";
            if ($service[0]->type == 1) {
                $type = "Offre de service";
            } elseif ($service[0]->type == 2) {
                $type = "Avis de recherche";
            }

            $type_annonceur = "";
            if ($service[0]->annonceur_type == 0) {
                $type_annonceur = "Particulier";
            } elseif ($service[0]->annonceur_type == 1) {
                $type_annonceur = "Professionnel";
            }

            $payement = "";
            if ($service[0]->paiement_type == 1) {
                $payement = "Oui";
            } elseif ($service[0]->paiement_type == 2) {
                $payement = "Non";
            } elseif ($service[0]->paiement_type == 3) {
                $payement = "A convenir";
            } 


            $serviceRelated = Service::where('status', '1')->where('city_id', $service[0]->city_id)->where('category_id', $service[0]->category_id)->where('id', '!=', $service[0]->id)->latest()
                ->take(4)
                ->get();
            // dd($serviceRelated);
            return view('service.info', compact('service', 'categories', 'ads', "payement", "type", 'serviceRelated','sliders','type_annonceur'));
        } catch (\Throwable $th) {
            return redirect()->back();
        }
    }


    public function index_front(Request $request)
    {

        try {
            // $types = ClassifiedTypes::all();
            $cities = City::all();
            // $areas = Area::all();
            $type_payement = ServiceType::where("type", "payement_type")->get();
            $sliders = Slider::all();
            $ads=Ad::where('active',1)->get();
            $categories = ServiceCategory::all();
            // $classifieds=Classified::where('status',1)->orderBy("updated_at","desc")->paginate(12);
            $query = Service::where('status', 1);
            if ($request->filled('reference')) {
                // dd($request->input('reference'));
                $searchTerm = $request->input('reference');
                $query->where(function ($query) use ($searchTerm) {
                    $query->where('ref', 'like', "%$searchTerm%")
                        ->orWhere('title', 'like', "%$searchTerm%");
                });
            }

            if ($request->filled('type')) {


                $query->where('type', $request->input('type'));
            }

            if ($request->filled('category_id')) {
                $query->where('category_id', $request->input('category_id'));
            }

            if ($request->filled('type_payement_id')) {
                $query->where('paiement_type', $request->input('type_payement_id'));
            }

            if ($request->filled('city_id')) {
                $query->where('city_id', $request->input('city_id'));
            }


            $services = $query->orderBy('updated_at', 'desc')->paginate(24);

            return view("service.index", compact("services", "categories", "cities","type_payement",'sliders',"ads"));
        } catch (\Throwable $th) {
            return redirect()->back();
        }
    }
}
