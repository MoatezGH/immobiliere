<?php

namespace App\Http\Controllers\Classified;

use App\Models\Ad;
use App\Models\Area;
use App\Models\City;
use App\Models\Slider;
use App\Models\Classified;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\ClassifiedTypes;
use App\Models\ClassifiedPicture;
use App\Models\ClassifiedCategory;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;
use App\Http\Requests\StoreClassifiedRequest;

class AnnonceController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->guard('classified_user')->user();
        $query = Classified::where('user_id', $user->id);
        if ($request->filled('keywords')) {
            $keywords = $request->input('keywords');
    
            $query->where(function ($query) use ($keywords) {
                $query->where('ref', 'like', '%' . $keywords . '%')
                    ->orWhere('title', 'like', '%' . $keywords . '%');
            });
        }
        $classifieds=$query->orderBy("updated_at", "desc")->paginate(12);
        // ->orderBy("updated_at", "desc")->paginate(12);
        return view("dashboard_classified.annonces.index", compact("classifieds"));
    }

    public function showAdd()
    {

        $types = ClassifiedTypes::all();
        $cities = City::all();
        $areas = Area::all();

        $categories = ClassifiedCategory::all();
        return view("dashboard_classified.annonces.add", compact("types", "categories", "cities", "areas"));
    }


    public function store(StoreClassifiedRequest  $request)
    {
        

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
                'user_id' => auth()->guard("classified_user")->user()->id, // Assuming the user is authenticated
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
            return redirect()->route('show_add_images', ['classified' => $classified->id])->with('success', 'Annonce créée avec succès.');
        } catch (\Throwable $e) {
            // $e->getMessage();
            return redirect()->back()->with('error', 'La création l\'annonce a échoué.');
        }
    }


    public function showAddImages($classifiedId)
    {
        // dd($classifiedId);
        $classified = Classified::findOrFail($classifiedId);
        return view("dashboard_classified.annonces.add_image")->with(["classified" => $classified]);
    }

    public function showUpdateImages($classifiedId)
    {
        // dd($classifiedId);
        $classified = Classified::findOrFail($classifiedId);
        return view("dashboard_classified.annonces.edit_image")->with(["classified" => $classified]);
    }


    public function AddImages(Request $request, Classified $classified)
    {
        // dd($request->all());
        try {
            $classified->status = 0;

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

            return redirect()->route('index_classified')->with("success", 'Annonce crée/modifier avec succès');
        } catch (\Throwable $e) {
            return redirect()->back()->withErrors(['propertyError' => 'Une erreur s\'est produite lors de la mise à jour des images de l\'annonce.']);
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

            $classified->update([

                'status' => 0,
            ]);
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



    public function index_front(Request $request)
    {

        try {
            $types = ClassifiedTypes::all();
            $cities = City::all();
            $areas = Area::all();
            $sliders = Slider::all();
            $ads=Ad::where('active',1)->get();

            $categories = ClassifiedCategory::all();
            // $classifieds=Classified::where('status',1)->orderBy("updated_at","desc")->paginate(12);
            $query = Classified::where('status', 1);
            if ($request->filled('reference')) {
                // dd($request->input('reference'));
                $searchTerm = $request->input('reference');
                $query->where(function ($query) use ($searchTerm) {
                    $query->where('ref', 'like', "%$searchTerm%")
                        ->orWhere('title', 'like', "%$searchTerm%");
                });
            }

            if ($request->filled('type_id')) {


                $query->where('product_type', $request->input('type_id'));
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

            if ($request->filled('min_price') || $request->filled('max_price')) {

                $minPrice = $request->input('min_price');
                if ($minPrice == null) $minPrice = "0";

                $maxPrice = $request->input('max_price');
                if ($maxPrice == null) $maxPrice = "1000000000000";

                $query->whereBetween('price', [$minPrice, $maxPrice]);
            }



            $classifieds = $query->orderBy('created_at', 'desc')->paginate(24);




            return view("classified.index", compact("classifieds", "types", "categories", "cities", "areas","sliders","ads"));
        } catch (\Throwable $th) {
            return redirect()->back();
        }
    }



    function get_classified_info($slug)
    {
        // dd("ddd");
        try {
            $classified = Classified::where('slug', $slug)->get();
            // dd($classified);
            if (!$classified) {
                return redirect()->back();
            }
            $classified[0]->incrementViewCount();

            $categories = ClassifiedCategory::all();

            $sliders = Slider::all();

            $ads = Ad::where('active', 1)->get();

            $type = "";
            if ($classified[0]->product_type == 0) {
                $type = "Vente";
            } elseif ($classified[0]->product_type == 1) {
                $type = "Don";
            } elseif ($classified[0]->product_type == 2) {
                $type = "Avis de recherche";
            }

            $condition = "";
            if ($classified[0]->product_condition == 1) {
                $condition = "Neuf";
            } elseif ($classified[0]->product_condition == 2) {
                $condition = "Quasi Neuf";
            } elseif ($classified[0]->product_condition == 3) {
                $condition = "Occasion";
            } elseif ($classified[0]->product_condition == 4) {
                $condition = "A rénover";
            }


            $classifiedRelated = Classified::where('status', '1')->where('city_id', $classified[0]->city_id)->where('category_id', $classified[0]->category_id)->where('id', '!=', $classified[0]->id)->latest()
                ->take(4)
                ->get();
            // dd($propertyRelated);
            return view('classified.info', compact('classified', 'categories', 'ads', "condition", "type", 'classifiedRelated',"sliders"));
        } catch (\Throwable $th) {
            return redirect()->back();
        }
    }


    public function deleteImage($id)
    {

        try {
            // Find the picture by ID
            // $user=auth()->guard('classified_user')->user();
            // dd($user);

            $picture = ClassifiedPicture::findOrFail($id);
            // dd($picture);

            if (file_exists(public_path('uploads/classified/multi_images/' . $picture->picture_path))) {
                unlink(public_path('uploads/classified/multi_images/' . $picture->picture_path));
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


    public function showUpdate($classifiedId)
    {
        // dd($classifiedId);
        $classified = Classified::findOrFail($classifiedId);

        $types = ClassifiedTypes::all();
        $cities = City::all();
        $areas = Area::where("city_id", $classified->city_id)->get();

        $categories = ClassifiedCategory::all();
        return view("dashboard_classified.annonces.edit", compact("classified", "categories", "cities", "areas", "types"));
    }


    public function update(StoreClassifiedRequest $request, $id)
    {
        try {
            // Find the classified ad by its ID
            $classified = Classified::findOrFail($id);

            // Update the classified ad fields
            $classified->title = $request->title;
            $classified->category_id = $request->categorie_id;
            $classified->price = $request->price;
            $classified->advertis_type = $request->type_annonceur;
            $classified->product_type = $request->type_product;
            $classified->product_condition = $request->condition_product;
            $classified->description = $request->description ?? "";
            $classified->user_id = auth()->guard("classified_user")->user()->id; // Assuming the user is authenticated
            $classified->city_id = $request->city_id;
            $classified->area_id = $request->area_id;
            $classified->status = 0;


            // Optionally update the slug if the title has changed
            if ($classified->isDirty('title')) {
                $classified->slug = Str::slug($request->title) . '-' . uniqid();
            }

            // Save the updated classified ad to the database
            $classified->save();

            // Redirect or return a response
            return redirect()->route('index_classified')->with('success', 'Annonce mise à jour avec succès.');
        } catch (\Throwable $e) {
            // Handle any errors
            return redirect()->back()->with('error', 'La mise à jour de l\'annonce a échoué.');
        }
    }



    public function destroy($id)
    {
        try {
            // Find the classified ad by its ID
            $classified = Classified::findOrFail($id);
            

            // Delete the classified ad
            $classified->delete();

            // Redirect or return a response
            return redirect()->route('index_classified')->with('success', 'Annonce supprimée avec succès.');
        } catch (\Throwable $e) {
            // Handle any errors
            // dd($e->getMessage());

            // $e->getMessage();
            return redirect()->back()->with('error', 'La suppression de l\'annonce a échoué.');
        }
    }
}
