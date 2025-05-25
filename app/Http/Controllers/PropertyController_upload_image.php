<?php

namespace App\Http\Controllers;

use App\Models\Ad;
use App\Models\Area;
use App\Models\City;
use App\Models\Logo;
use App\Models\User;
use App\Models\Photo;
use App\Models\Category;
use App\Models\Property;
use App\Models\Operation;
use App\Models\Situation;
use App\Models\MainPicture;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\PromoteurProperty;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;
use App\Http\Requests\PropertyRequest;
use function PHPUnit\Framework\isEmpty;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class PropertyController extends Controller
{


    /**
     * Undocumented function
     *
     * @return void
     */
    public function get_add()
    {
        try {
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
            $logo = null;
            if (auth()->user()->store) {
                $logo = auth()->user()->store->logo;
            }
            // $logo = Logo::find($user->logo_id);
            $operations = Operation::all();
            $categories = Category::all();
            $cities = City::all();
            // $areas = Area::where("city_id", auth()->user()->city_id)->get();
            $situations = Situation::all();
            $areas =  array();

            if ($userAccount == "promoteur") {
                // dd('fff000');
                return view('dasboard_users.properties.promoteur.add', compact('logo', 'operations', 'categories', 'cities', 'situations', 'userAccount', 'areas'));
            }
            return view('dasboard_users.properties.add', compact('logo', 'operations', 'categories', 'cities', 'situations', 'userAccount', 'areas'));
        } catch (\Throwable $th) {
            return redirect()->back();
        }
    }
    // -------------------------------------------------------

    /**
     * Undocumented function
     *
     * @return void
     */
    public function getCount()
    {
        // try {
        $count = Property::count();

        return $count;
        // } catch (\Throwable $th) {
        //     //throw $th;
        // }
        // Get the count of all records in the properties table

    }
    // -------------------------------------------------------

    /**
     * Undocumented function
     *
     * @param [type] $cat
     * @return void
     */
    public function getRef($cat)
    {

        // Get the count of all records in the properties table
        $category = Category::find($cat);
        $count = $this->getCount() + 1;
        // dd($category->alias . $count);
        $ref = $category->alias . $count;

        return $ref;
    }
    // -------------------------------------------------------

    /**
     * Undocumented function
     *
     * @param PropertyRequest $request
     * @return void
     */
    public function store(PropertyRequest $request)
    {
        try {
            // dd($request->all());

            // if ($request->hasFile('video')) {
            //     dd($request->all());
            // }
            // dd("ee");
            $ref = $this->getRef($request->category_id);
            // Create new property
            $property = new Property();

            $property->user_id = auth()->user()->id;
            $property->token = $request->_token;
            $property->ref = $ref;
            $property->title = $request->title;
            $property->slug = Str::slug($request->title . random_int(5, 9999));
            $property->description = $request->description;
            $property->operation_id = $request->operation_id;
            $property->category_id = $request->category_id;
            $property->situation_id = $request->situation_id;
            $property->prixtotaol = $request->prixtotaol;
            $property->price = $request->prixtotaol;
            $property->display_price = isset($request->show_price) ? $request->show_price : 0;
            $property->active =  isset($request->publish_now) ? $request->publish_now : 0;
            $property->state = "waiting";
            $property->city_id = $request->city_id;
            $property->area_id = $request->area_id;
            $property->address = $request->address;
            // $property->code = $request->code;
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

            $property->floor_area = $request->floor_area;
            $property->plot_area = $request->plot_area;

            // dd($property);

            $property->save();
            
            // $this->updateMainPicture($request, $property);
            // $this->updatePropertyImages($request, $property);
            // return redirect()->back()->with('success', 'Annonce crée avec succés.');

            if ($property->wasRecentlyCreated) {
                // Redirect to the showUpload method with the property ID
                return redirect()->route('properties.upload', ['property' => $property])->with('success', 'Annonce crée avec succés.');
            } else {
                // Handle the case where saving failed (optional)
                // Redirect back or show an error message
                return back()->withInput()->withErrors(['error' => 'Une erreur s\'est produite lors de l\'ajout de votre annonce']);
            }
        } catch (\Exception $e) {
            // dd($e);
            return redirect()->back()->withErrors(['propertyError' => 'Une erreur s\'est produite lors de l\'ajout de votre annonce ']);
        }
    }
    // -------------------------------------------------------

    //update
    /**
     * Undocumented function
     *
     * @param PropertyRequest $request
     * @param Property $property
     * @return void
     */

    public function update(PropertyRequest $request, Property $property)
    {
        try {
            // dd($request->all());
            $error_message = "accès refusé";
            $this->checkUser($property, $error_message);
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
            $property->active =  isset($request->publish_now) ? $request->publish_now : 0;
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
            // $this->updateMainVideo($request, $property);


            return redirect()->route("all_user_property")->with('success', 'Propriété mise à jour avec succès.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['propertyError' => 'Une erreur s\'est produite lors de la modification de votre annonce ']);
        }
    }

    // -------------------------------------------------------

    /**
     * Undocumented function
     *
     * @param [type] $image
     * @param [type] $path
     * @param [type] $width
     * @param [type] $height
     * @return void
     */
    private function resizeImage($image, $path, $width, $height)
    {
        $extension = strtolower($image->getClientOriginalExtension());

        if (!in_array($extension, ['gif', 'png', 'jpg', 'jpeg'])) {
            throw new Exception('Format d\'image non pris en charge'); // Handle unsupported formats
        }

        $image = imagecreatefromstring($image->getContent());

        if (!$image) {
            throw new Exception('Échec de la création de l\'objet image'); // Handle image creation errors
        }

        $thumb = imagecreatetruecolor($width, $height);

        $sourceWidth = imagesx($image);
        $sourceHeight = imagesy($image);

        // Maintain aspect ratio (optional)
        $aspectRatio = min($width / $sourceWidth, $height / $sourceHeight);
        $newWidth = $sourceWidth * $aspectRatio;
        $newHeight = $sourceHeight * $aspectRatio;

        $offsetX = ($width - $newWidth) / 2;
        $offsetY = ($height - $newHeight) / 2;

        imagecopyresampled($thumb, $image, $offsetX, $offsetY, 0, 0, $newWidth, $newHeight, $sourceWidth, $sourceHeight);

        switch ($extension) {
            case 'gif':
                imagegif($thumb, $path);
                break;
            case 'png':
                imagepng($thumb, $path);
                break;

            default:
                imagejpeg($thumb, $path, 100); // Adjust quality as needed
                break;
        }

        imagedestroy($image);
        imagedestroy($thumb);
    }
    // -------------------------------------------------------

    /**
     * 
     * 
     *
     * @param Request $request
     * @return void
     */
    public function get_user_properties(Request $request)
    {
        try {
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

            // $logo = Logo::find($userType->logo_id);
            $logo = null;
            if (auth()->user()->store) {
                $logo = auth()->user()->store->logo;
            }

            // $props = Property::where("user_id", $user->id)->orderBy("created_at", 'desc')->paginate(7);
            $searchTerm = $request->input('keywords');


            // Build the query with optional title filtering
            $query = Property::where('user_id', $user->id);
            if ($searchTerm) {
                $query->where(function ($query) use ($searchTerm) {
                    $query->where('title', 'like', "%{$searchTerm}%")
                        ->orWhere('ref', 'like', "%{$searchTerm}%");
                });
            }
            // if ($searchTerm) {
            //     $query = $query->where('title', 'like', "%{$searchTerm}%");
            // }

            // Order and paginate the results
            $props = $query->orderBy('created_at', 'desc')->paginate(7);
            ///
            $categories = Category::all();

            return view("dasboard_users.properties.all_props_user", compact("props", "logo", "userAccount", "searchTerm", 'categories'));
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->back();
        }
    }
    // -------------------------------------------------------

    /**
     * Undocumented function
     *
     * @param Property $property
     * @return void
     */
    public function delete(Property $property)
    {
        // dd('tst');
        try {
            //dd($property);
            // dd($property->pictures);

            $user = auth()->user();
            $error_message = "Annonce non suprimer";
            // dd($error_message);
            $test = $this->checkUser($property, $error_message);
            // dd($test);
            if ($property->user_id != $user->id) {
                // dd("no");
                return redirect()->back()->withErrors(['propertyError' => 'Annonce non suprimer']);
            }
            // dd('eee');
            //delete main picture
            if ($property->main_picture) {
                // dd($property->main_picture->alt);
                $mainPicturePath = public_path('uploads/main_picture/images/properties/' . $property->main_picture->alt);
                if (file_exists($mainPicturePath)) {
                    unlink($mainPicturePath);
                }
            }

            // Delete additional pictures
            foreach ($property->pictures as $picture) {
                $picturePath = public_path('uploads/property_photo/'.$picture->alt);
                if (file_exists($picturePath)) {
                    unlink($picturePath);
                }
                $picture->delete(); // Delete picture record from database
            }
            // dd('esssesse');

            $property->delete();
            // dd($res);

            return redirect()->back()->with('success', 'Annonce suprimer avec success');
        } catch (\Exception $e) {
            return redirect()->back()->with('withErrors', 'Annonce suprimer avec success');;
        }
    }
    // -------------------------------------------------------

    /**
     * Undocumented function
     *
     * @param [type] $slug
     * @return void
     */
    public function EditProperty($slug)
    {
        try {
            $property = Property::where('slug', 'like', "%{$slug}%")->get();
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

            $logo = Logo::find($user->logo_id);
            $operations = Operation::all();
            $categories = Category::all();
            $cities = City::all();
            $areas = Area::where("city_id", $property[0]['city_id'])->get();
            $areasArray = $areas->toArray();
            $situations = Situation::all();

            if ($userAccount == "promoteur") {
                // dd('fff000');
                return view('dasboard_users.properties.promoteur.add', compact('logo', 'operations', 'categories', 'cities', 'situations', 'userAccount', "areasArray"));
            }
            return view('dasboard_users.properties.edit', compact('logo', 'operations', 'categories', 'cities', 'situations', 'userAccount', "property", "areas", "areasArray"));
        } catch (\Throwable $th) {
            return redirect()->back();
        }
    }
    /**
     * Undocumented function
     *
     * @param [type] $property
     * @param [type] $error_message
     * @return void
     */

    private function checkUser($property, $error_message)
    {
        // dd($property);
        $user = auth()->user()->id;

        // dd($user);
        if ($property->user_id != $user) {
            return redirect()->back()->withErrors(['propertyError' => $error_message]);
        };
    }
    // -------------------------------------------------------

    /**
     * Undocumented function
     *
     * @param Request $request
     * @return void
     */
    function get_all_properties_front(Request $request)
    {
        try {
            // dd($request->all());
            $categories = Category::all();
            $cities = City::all();
            $operations = Operation::all();
            $query = Property::where('state', 'valid')->where('active', '1');
            if ($request->filled('reference')) {
                // dd($request->input('reference'));
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
            // if ($request->filled('min_price') && $request->filled('max_price')) {
            //     $minPrice = $request->input('min_price');
            //     $maxPrice = $request->input('max_price');
            //     $query->whereBetween('price', [$minPrice, $maxPrice]);
            // }

            if ($request->filled('min_price') || $request->filled('max_price')) {

                $minPrice = $request->input('min_price');
                if ($minPrice == null) $minPrice = "0";

                $maxPrice = $request->input('max_price');
                if ($maxPrice == null) $maxPrice = "0";

                $query->whereBetween('price', [$minPrice, $maxPrice]);
            }


            // dd($query->toSql());

            // dd([
            //     'query' => $query->toSql(),
            //     'bindings' => $query->getBindings()
            // ]);
            $props = $query->orderBy('created_at', 'desc')->paginate(24);
            // dd($props);
            return view('properties.index', compact('props', 'categories', 'cities', 'operations'));
        } catch (\Throwable $th) {
            return redirect()->back();
        }
    }
    // -------------------------------------------------------
    /**
     * Undocumented function
     *
     * @param [type] $slug
     * @return void
     */
    function get_prop_info($slug)
    {
        // dd('tes');
        try {
            $property = Property::where('slug', 'like', "%{$slug}%")->get();
            if (!$property) {
                return redirect()->back();
            }
            $property[0]->incrementViewCount();

            // $property[0]->count_views = $property[0]->count_views + 1;
            $categories = Category::all();
            $user_prop = User::find($property[0]->user_id);

            $userAccount = $user_prop->checkType();
            // dd($property[0]->count_views);
            // dd("ee");

            $ads=Ad::where('active',1)->get();

            // dd($ads);
            // dd($userAccount);

            switch ($userAccount) {
                case 'company':
                    $user = $user_prop->company;

                    break;
                case 'particular':
                    $user = $user_prop->particular;

                    break;

                default:
                    $user = $user_prop->promoteur;

                    break;
            }
            // dd($user);

            // $user_logo = Logo::find($user->logo_id);
            // dd($user->user);
            // dd($user->corporate_name);

            $user_logo = null;
            if ($user && $user->store) {
                // dd("ee002");

                $user_logo = $user->store->logo;
            }
            $propertyRelated = Property::where('state', 'valid')->where('city_id', $property[0]->city_id)->where('operation_id', $property[0]->operation_id)->where('category_id', $property[0]->category_id)->where('id', '!=', $property[0]->id)->latest()
                ->take(3)
                ->get();

            return view('properties.info', compact('property', 'user', 'user_logo', 'categories', 'propertyRelated','ads'));
        } catch (\Throwable $th) {
            return redirect()->back();
        }
    }
    // -------------------------------------------------------

    /**
     * Undocumented function
     *
     * @param [type] $slug
     * @return void
     */
    function get_prop_promoteur_info($slug)
    {
        // dd("ddd");
        try {
            $property = PromoteurProperty::where('slug', 'like', "%{$slug}%")->get();
            if (!$property) {
                return redirect()->back();
            }
            $property[0]->incrementViewCount();

            $categories = Category::all();

            $user_prop = User::find($property[0]->user_id);
            $userAccount = $user_prop->checkType();
            // dd($userType);
            $ads=Ad::where('active',1)->get();

            switch ($userAccount) {
                case 'company':
                    $user = $user_prop->company;

                    break;
                case 'particular':
                    $user = $user_prop->particular;

                    break;

                default:
                    $user = $user_prop->promoteur;

                    break;
            }
            // $user_logo = Logo::find($user->logo_id);
            // dd($user->user->store->logo);

            $user_logo = null;
            if ($user->user->store) {
                // dd($user);

                $user_logo = $user->user->store->logo;
            }
            // dd("test");

            $propertyRelated = PromoteurProperty::where('status', '1')->where('city_id', $property[0]->city_id)->where('operation_id', $property[0]->operation_id)->where('category_id', $property[0]->category_id)->where('id', '!=', $property[0]->id)->latest()
                ->take(4)
                ->get();
            // dd($propertyRelated);
            return view('properties.promoteur.info', compact('property', 'user', 'user_logo', 'categories', 'propertyRelated','ads'));
        } catch (\Throwable $th) {
            return redirect()->back();
        }
    }
    // -------------------------------------------------------
    /**
     * Undocumented function
     *
     * @param [type] $id
     * @return void
     */
    public function deleteImage($id)
    {

        try {
            // Find the picture by ID
            $picture = Photo::findOrFail($id);
            // dd($picture->property);
            // dd("re00");

            // if(!Auth::is_admin()){
            //     dd("re");
            //     if (Auth::id() !== $picture->property->user_id ) {
                
            //         return redirect()->back()->with('error', 'Vous \'êtes pas autorisé à supprimer cette image');
            //     }
            // }
            // dd("re23");
            // Delete the picture from storage
            // You might want to add some error handling here
            if (file_exists(public_path('uploads/property_photo/' . $picture->alt))) {
                unlink(public_path('uploads/property_photo/' . $picture->alt));
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
    // -------------------------------------------------------


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

    //vedio

    private function updateMainVideo($request, $property)
    {
        // Validate the incoming request
        // $validator = Validator::make($request->all(), [
        //     'video' => 'file|mimes:mp4,mov,avi|max:20480', // Adjust the file types and size as needed
        // ]);

        // if ($validator->fails()) {
        //     // Handle validation failure
        //     // return response()->json(['error' => $validator->errors()], 400);
        // }

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

    // private function updateMainVideo($request, $property)
    // {
    //     if ($request->hasFile('vedio')) {
    //         $video = $request->file('vedio');

    //         // Generate a unique filename
    //         $extension = $video->getClientOriginalExtension();
    //         $str_random = Str::random(8);
    //         $videopath = $str_random . time() . "." . $extension;

    //         // Save the video file to the desired location
    //         $video->move(public_path('uploads/videos/properties/'), $videopath);



    //         // Update the property's video_id with the ID of the new main video
    //         $property->video_path = $videopath;
    //         $property->save();
    //     }
    // }

    public function showUpload(Property $property)
    {

// dd($property);
        if (!$property) {
            // Handle the case where property is not found
            return redirect()->route('properties.index')->withErrors('Property not found.');
        }

        return view("dasboard_users.properties.upload_images", compact("property"));
    }

    public function uploaded (Request $request,Property $property){
        // dd($request);
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
            return redirect()->back()->with('success', 'Les médias de la propriété ont été mis à jour avec succès.');
    }
}
