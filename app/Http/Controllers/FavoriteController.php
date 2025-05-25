<?php

namespace App\Http\Controllers;



use App\Models\Favorite;
use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{

    public function index()
    {
        $user = Auth::user();
        $favorites = $user->favorites()->with('favoritable')->paginate(6);
        // dd($favorites);
        return view('dasboard_users.favories.index', compact('favorites'));
    }
    public function store(Request $request, $favoritableType, $favoritableId)
    {
        try {

            $user = Auth::user();

            $favoritableModel = app($favoritableType);

            $favoritable = $favoritableModel->findOrFail($favoritableId);

            if (!$favoritable) {
                return redirect()->back();
            }

            if ($user->favorites()->where('favoritable_type', $favoritableType)->where('favoritable_id', $favoritableId)->exists()) {

                return redirect()->back()->with("error", "L\'annonse est déjà dans les favoris");
            }

            $favorite = new Favorite([
                'user_id' => $user->id,
                'favoritable_id' => $favoritable->id,
                'favoritable_type' => $favoritableType,
            ]);
            $favorite->save();

            return redirect()->back()->with("successFav", "Propriété ajoutée aux favoris");
        } catch (\Throwable $th) {
            return redirect()->back()->with("error", "Problème de connection");
        }
    }

    public function destroy(Request $request, $favoritableType, $favoritableId)
    {

        try {
            $user = Auth::user();

            $favorite = $user->favorites()
                ->where('favoritable_type', $favoritableType)
                ->where('favoritable_id', $favoritableId)
                ->firstOrFail();


            if ($favorite) {
                $favorite->delete();

                return redirect()->back()->with("successFav", "Annonce supprimée des favoris");
            }
        } catch (\Throwable $th) {
            return redirect()->back()->with("error", "Problème de connection");
        }
    }
}
