<?php

namespace App\Http\Controllers\Classified;

use App\Models\Area;
use App\Models\City;
use App\Models\Classified;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\ClassifiedTypes;
use App\Models\ClassifiedPicture;
use App\Models\Property_features;
use App\Models\ClassifiedCategory;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;
use App\Http\Requests\StoreClassifiedRequest;

class AdminClassifiedController extends Controller
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

public function showAdd()
    {

        $types = ClassifiedTypes::all();
        $cities = City::all();
        $areas = Area::all();

        $categories = ClassifiedCategory::all();
        return view("classified_admin.annonces.add", compact("types", "categories", "cities", "areas"));
    }
public function store(StoreClassifiedRequest  $request)
    {
        // dd($request->all());

        try {
            $slug = Str::slug($request->title) . '-' . uniqid();
            $classified = new Classified([
                'title' => $request->title,
                'category_id' => $request->categorie_id,
                'price' => $request->price,
                'advertis_type' => $request->type_annonceur,
                'product_type' => $request->type_product,
                'product_condition' => $request->condition_product,
                'description' => $request->description ?? "",
                'user_id' => auth()->user()->id, // Assuming the user is authenticated
                'ref' => uniqid(), // Generate a unique reference
                'status' => 0, // Default status
                'slug' => $slug,
                'city_id' => $request->city_id,
                'area_id' => $request->area_id,
                'synced' =>  isset($request->synced) ? true : false
            ]);

            // dd($classified);

            // Save the classified ad to the database
            $classified->save();
            // dd($res);
            // Redirect or return a response
            return redirect()->route('admin_show_add_images', ['classified' => $classified->id])->with('success', 'Annonce créée avec succès.');
        } catch (\Throwable $e) {
            // $e->getMessage();
            return redirect()->back()->with('error', 'La création l\'annonce a échoué.');
        }
    }


    public function showAddImages($classifiedId)
    {
        // dd($classifiedId);
        $classified = Classified::findOrFail($classifiedId);
        return view("classified_admin.annonces.add_image")->with(["classified" => $classified]);
    }
    public function index(Request $request)
    {
        $query = Classified::query();

        $categories = ClassifiedCategory::all();
        $userName ="";
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


        $classifieds = $query->orderBy('created_at', 'desc')
            ->paginate(10);
        $featuresExist = [];
        foreach ($classifieds as $classifed) {
            $featuresExist[$classifed->id] = Property_features::where('property_id', $classifed->id)->where("type__","classified")->exists();
        }

        return view('classified_admin.index', compact("classifieds", "featuresExist","categories","userName"));
    }


    function get_classified_info($id)
    {
        // dd('eeee');
        try {
            $property = Classified::find($id);
            // dd($property);
            return view('classified_admin.info', compact('property'));
        } catch (\Throwable $th) {
            return redirect()->back(); //throw $th;
        }
    }


    public function updateStatusClassified(Request $request, $id)
    {
        try {
            // Retrieve the property by its ID
            $property = Classified::findOrFail($id);
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
            return redirect()->back()->with('success', 'Statut de la Débarras mis à jour avec succès.');
        } catch (\Exception $e) {
            // Handle the exception
            return redirect()->back()->with('error', 'Erreur lors de la mise à jour de l\'état de la débarras : ');
        }
    }


    public function destroy($id)
    {
        try {
            // Find the classified ad by its ID
            $classified = Classified::findOrFail($id);
            

                $perimium = Property_features::where('property_id', $classified->id)
                    ->where('type__', 'classified')
                    ->first();
                if ($perimium) {
                    $perimium->delete();
                }
            

            // Delete the classified ad
            $classified->delete();

            // Redirect or return a response
            return redirect()->route('admin_classifieds')->with('success', 'Annonce supprimée avec succès.');
        } catch (\Throwable $e) {
            
            return redirect()->back()->with('error', 'La suppression de l\'annonce a échoué.');
        }
    }


    public function showUpdate($classifiedId)
    {
        // dd($classifiedId);
        $classified = Classified::findOrFail($classifiedId);

        $types = ClassifiedTypes::all();
        $cities = City::all();
        $areas = Area::where("city_id", $classified->city_id)->get();

        $categories = ClassifiedCategory::all();
        return view("classified_admin.annonces.edit", compact("classified", "categories", "cities", "areas", "types"));
    }


    public function update(StoreClassifiedRequest $request, $id)
    {
        try {
            // Find the classified ad by its ID
            $classified = Classified::findOrFail($id);
            // dd("e");
            // Update the classified ad fields
            $classified->title = $request->title;
            $classified->category_id = $request->categorie_id;
            $classified->price = $request->price;
            $classified->advertis_type = $request->type_annonceur;
            $classified->product_type = $request->type_product;
            $classified->product_condition = $request->condition_product;
            $classified->description = $request->description ?? "";
            // Assuming the user is authenticated
            $classified->city_id = $request->city_id;
            $classified->area_id = $request->area_id;
            $classified->status = 0;
            // dd($classified);

            // Optionally update the slug if the title has changed
            if ($classified->isDirty('title')) {
                $classified->slug = Str::slug($request->title) . '-' . uniqid();
            }

            // Save the updated classified ad to the database
            $classified->save();
            // dd($res);
            // Redirect or return a response
            return redirect()->route('admin_show_update_images',['classified' => $classified->id])->with('success', 'Annonce mise à jour avec succès.');
        } catch (\Throwable $e) {
            // Handle any errors
            return redirect()->back()->with('error', 'La mise à jour de l\'annonce a échoué.');
        }
    }


    //main picture
    private function updateMainPicture($request, $classified)
    {

        if ($request->hasFile('photos_main')) {

            if ($classified->mainPicture) {
                $oldPicturePath = public_path('uploads/classified/main_picture/' . $classified->mainPicture->picture_path);
                if (file_exists($oldPicturePath)) {
                    unlink($oldPicturePath);
                }
                $classified->mainPicture->delete();
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
            $img->save(public_path('uploads/classified/main_picture/' . $imgpath), 100);


            // $existingMainImage = $property->images()->where('is_main', 1)->first();
            // //dd($existingMainImage);
            // if ($existingMainImage) {
            //     $existingMainImage->is_main = 0;
            //     $existingMainImage->save();
            // }
            // Create a record in the database for the new main picture
            $classified->mainPicture()->create([
                'picture_path' =>  $imgpath,
                'classified_id' => $classified->id,
            ]);

            // $classified->update([

            //     'status' => 0,
            // ]);
            // dd($classified);
        }
    }


    //multi image
    private function updateClassifiedImages($request, $classified)
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
                $img->save(public_path('uploads/classified/multi_images/' . $imgpath), 100);

                // Create a record in the database for the new main picture
                $classified->pictures()->create([
                    'picture_path' =>  $imgpath,
                    'classified_id' => $classified->id,
                ]);
            }
        }
    }


    public function showUpdateImages($classifiedId)
    {
        try {
            // dd($classifiedId);
        $classified = Classified::findOrFail($classifiedId);
        return view("classified_admin.annonces.edit_image")->with(["classified" => $classified]);
        } catch (\Throwable $e) {
            return redirect()->back();
        }
        
    }

    public function AddImages(Request $request, Classified $classified)
    {
        // dd($request->all());
        try {
            // $classified->status = 0;

            try {
                $this->updateMainPicture($request, $classified);
            } catch (\Exception $e) {
                return redirect()->back()->withErrors(['propertyError' => 'Une erreur s\'est produite lors de la mise à jour de la photo principale.']);
            }

            try {
                $this->updateClassifiedImages($request, $classified);
            } catch (\Exception $e) {
                return redirect()->back()->withErrors(['propertyError' => 'Une erreur s\'est produite lors de la mise à jour des images de l\'annonce.']);
            }
            $classified->save();

            return redirect()->route('admin_classifieds')->with("success", 'Annonce crée/modifier avec succès');
        } catch (\Throwable $e) {
            redirect()->back()->with("error", 'La mise à jour de l\'annonce a échoué.');
        }
    }


    public function deleteImage($id)
    {

        try {
            // Find the picture by ID
            $picture = ClassifiedPicture::findOrFail($id);

            if (file_exists(public_path('uploads/classified/multi_images' . $picture->picture_path))) {
                unlink(public_path('uploads/classified/multi_images' . $picture->picture_path));
            }

            // Delete the picture from the database
            $picture->delete();

            // Redirect back with a success message
            return response()->json(['success' => 'Photo Deleted Successfully!']);

        } catch (\Throwable $th) {
            return redirect()->back();
        }
    }
}
