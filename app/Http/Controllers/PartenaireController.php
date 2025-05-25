<?php

namespace App\Http\Controllers;

use App\Models\Partenaire;
use App\Models\Statistique;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class PartenaireController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $user = auth()->user();
        if (!$user->isAdmin()) {
            return redirect()->back();
        }
        $partenaires = Partenaire::orderBy("created_at","desc")->paginate(8);
        // dd($sliders);
        return view("dashboard_admin.partenaires.index", compact("partenaires"));
        } catch (\Throwable $e) {
            return redirect()->back();

        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        try {
            $user = auth()->user();
        if (!$user->isAdmin()) {
            return redirect()->back();
        }

        return view("dashboard_admin.partenaires.add");
        } catch (\Throwable $e) {
            return redirect()->back();

        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            // dd($request->all());
            $user = auth()->user();

            if (!$user->isAdmin()) {
                return redirect()->back();
            }
            $partenaire = new Partenaire();
            $partenaire->description = $request->title;
            $partenaire->url = $request->lien ?? "";
            $partenaire->status =
                isset($request->publish_now) ? $request->publish_now : 0;
            if ($request->hasFile('photos_main')) {
                $image = $request->photos_main;

                $img = Image::make($image);
                $extension = $image->extension();
                $str_random = Str::random(8);
                // $img->resize(729, 398);
                $img->resize(
                    729,
                    398
                );

                $imgpath = $str_random . time() . "." . $extension;

                // Save the resized image
                $img->save(public_path('uploads/partenaire/' . $imgpath), 100);


                $partenaire->image_url = $imgpath;


                // Update the property's image_id with the ID of the new main picture

                // $property->save();
            }
            // dd($partenaire);

            $partenaire->save();

            return redirect()->back()->with('success', 'Partenaire crée avec succés.');
        } catch (\Exception $e) {
            // dd($e);
            return redirect()->back()->withErrors(['propertyError' => 'partenaire ne pas enregistrer' ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Partenaire $partenaire)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        try {
            $user = auth()->user();
            if (!$user->isAdmin()) {
                return redirect()->back();
            }
            $partenaire = Partenaire::find($id);
            // dd($partenaire);
            return view("dashboard_admin.partenaires.edit", compact('partenaire'));
        } catch (\Throwable $e) {
            return redirect()->back();
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Partenaire $partenaire)
    {
        try {
            $user = auth()->user();

            if (!$user->isAdmin()) {
                return redirect()->back();
            }
                // dd($partenaire);
                //             $property = Partenaire::findOrFail($partenaire);

            $partenaire->description = $request->title;
            $partenaire->url = $request->lien ?? "";
            $partenaire->status = isset($request->publish_now) ? $request->publish_now : 0;

            if ($request->hasFile('photos_main')) {
                $newImage = $request->file('photos_main');
                $newImageHash = md5_file($newImage->getRealPath());

                // Check if the existing image file exists
                $oldImagePath = public_path('uploads/partenaire/' . $partenaire->image_url);
                if (file_exists($oldImagePath)) {
                    $oldImageHash = md5_file($oldImagePath);

                    // If the old and new images are the same, skip the update
                    if ($newImageHash === $oldImageHash) {
                        return redirect()->back()->with('success', 'Slider mis à jour avec succès (aucune modification d\'image).');
                    }

                    // Delete the old image if they are different
                    @unlink($oldImagePath);
                }

                // Process and save the new image
                $newImageName = Str::random(8) . time() . '.' . $newImage->extension();
                $img = Image::make($newImage);
                $img->resize(1920, 1280);
                $img->save(public_path('uploads/partenaire/' . $newImageName), 100);

                // Update the property with the new image
                $partenaire->image_url = $newImageName;
            }

            $partenaire->save();

            return redirect()->back()->with('success', 'Partenaire mis à jour avec succès.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['propertyError' => 'Partenaire non enregistré: ' ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Partenaire $partenaire)
    {
        try {
            $user = auth()->user();
            if (!$user->isAdmin()) {
                return redirect()->back();
            }
            // $slider = Slider::find($id);
            $partenaire->delete();
            return redirect()->back()->with("success","Partenaire est supprimé");
        } catch (\Throwable $e) {
            return redirect()->back();
        }
    }


    public function incrementViewCount(Request $request,$id)
    {
        try {
            // dd($id);
            $partenair = Partenaire::findOrFail($id);
            $partenair->increment('view_count');
            Statistique::create([
                'user_id' => $id,
                'action_type' => "partenaire_web",

                'ip'=>request()->ip()
            ]);
            // return response()->json(['url' => $partenair->url]);:
            $url=$partenair->url ?? "#";
            return redirect($url);
        } catch (\Throwable $e) {
            // Optionally log the error
            // Log::error($e);
            return response()->json(['error' => 'An error occurred while processing your request.'], 500);
        }
        
    }
}
