<?php

namespace App\Http\Controllers\ServicesUser;

use App\Models\Area;
use App\Models\City;
use App\Models\Service;
use App\Models\ServiceType;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\ServiceCategory;
use App\Models\Property_features;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;

class AdminServiceController extends Controller
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
        // dd("eee");

        try {
            $query = Service::query();
            // $services = $query->orderBy('created_at', 'desc')->paginate(10);

            $categories = ServiceCategory::orderBy('name')->get();
            $userName = "";
            if ($request->filled('user_name')) {
                $userName = $request->input('user_name');
            
                // Filter by related user full_name
                // $query->whereHas('user', function ($query) use ($userName) {
                //     $query->where('full_name', 'like', '%' . $userName . '%');
                // });
            
                // Filter by ref or title matching userName
                $query->where(function ($query) use ($userName) {
                    $query->where('ref', 'like', '%' . $userName . '%')
                          ->orWhere('title', 'like', '%' . $userName . '%');
                });
            }

            // if ($request->filled('user_name')) {
            //     $userName = $request->input('user_name');
            //     $query->whereHas('user', function ($query) use ($userName) {
            //         $query->where(
            //             'full_name',
            //             'like',
            //             '%' . $userName . '%'
            //         );
            //     });
            //     $query->where('ref', $userName);
            //     $query->where('title', $userName);

            // }
            if ($request->filled('status')) {
                $query->where('status', $request->input('status'));
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


            $services = $query->orderBy('created_at', 'desc')->paginate(10);
            // dd($services);
            // die();
            $featuresExist = [];
            foreach ($services as $service) {
                $featuresExist[$service->id] = Property_features::where('property_id', $service->id)->where("type__", "service")->exists();
            }
            // dd($featuresExist);
            return view('services_admin.index', compact("services", "featuresExist", "categories","userName"));
        } catch (\Throwable $e) {
            return redirect()->back();
        }
    }


    function get_service_info($id)
    {
        // dd('eeee');
        try {
            $property = Service::find($id);
            // dd($property);
            return view('services_admin.info', compact('property'));
        } catch (\Throwable $th) {
            return redirect()->back(); //throw $th;
        }
    }


    public function updateStatusService(Request $request, $id)
    {
        try {
            // Retrieve the property by its ID
            $property = Service::findOrFail($id);
            // dd($property);

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
            return redirect()->back()->with('success', 'Statut de service mis à jour avec succès.');
        } catch (\Exception $e) {
            // Handle the exception
            return redirect()->back()->with('error', 'Erreur lors de la mise à jour de l\'état de la service.');
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


            // Delete the service ad
            $service->delete();

            // Redirect or return a response
            return redirect()->route('admin_services')->with('success', 'Annonce supprimée avec succès.');
        } catch (\Throwable $e) {
            // Handle any errors
            // dd($e->getMessage());

            // $e->getMessage();
            return redirect()->back()->with('error', 'La suppression de l\'annonce a échoué.');
        }
    }


    //edit
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

            return view("services_admin.edit", compact("service", "categories", "cities", "areas", "type_payement"));
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
            return redirect()->route('admin_show_add_images_service', ['service' => $service->id])->with('success', 'Service mise à jour avec succès.');
        } catch (\Throwable $e) {
            // return $e->getMessage();
            // Handle any errors
            return redirect()->back()->with('error', 'La mise à jour de service a échoué.');
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

    public function showAddImages($serviceId)
    {
        // dd($serviceId);
        $service = Service::findOrFail($serviceId);
        return view("services_admin.edit_image")->with(["service" => $service]);
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

            return redirect()->route('admin_services')->with("success", 'Service crée/modifier avec succès');
        } catch (\Throwable $e) {
            // return $e->getMessage();
            return redirect()->back();

        }
    }
}
