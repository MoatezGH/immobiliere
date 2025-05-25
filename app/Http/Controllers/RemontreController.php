<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Property;
use App\Models\Classified;
use Illuminate\Http\Request;
use App\Models\PromoteurProperty;

class RemontreController extends Controller
{
    public function remonter(Request $request, $id)
    {
        //dd($request->all());
        //$annonce = Annonce::findOrFail($id);
        $user = auth()->user();

        // Vérifiez si l'utilisateur a atteint le maximum de remontées
        // if ($user->total_remonte_count >= 10) {
        //     return redirect()->route('annonces.index')->with('error', 'Vous avez atteint le nombre maximum de remontées pour vos annonces.');
        // }

        if ($request->type == "property") {
            $annonce = Property::find($id);
            // $featuredCount = Property::where('user_id', $user->id)->where('remonter', true)->count();
        } elseif ($request->type == "promoteur_property") {
            $annonce = PromoteurProperty::find($id);
            // $featuredCount = PromoteurProperty::where('user_id', $user->id)->where('remonter', true)->count();
        }elseif ($request->type == "service") {
            $annonce = Service::find($id);
            // $featuredCount = PromoteurProperty::where('user_id', $user->id)->where('remonter', true)->count();
        }elseif ($request->type == "debaras") {
            $annonce = Classified::find($id);
            // $featuredCount = PromoteurProperty::where('user_id', $user->id)->where('remonter', true)->count();
        }
        // dd($annonce);
        if (!$annonce) {
            return redirect()->back()->with('error', 'annonce introuvable');
        }
        // Vérifiez si l'utilisateur a atteint le maximum d'annonces mises en avant
        // if ($featuredCount >= 10) {
        //     return redirect()->back()->with('error', 'Vous avez atteint le nombre maximum d\'annonces mises en avant.');
        // }


        $annonce->remonter = true;
        $annonce->touch();
        // dd($annonce);
        $annonce->save();



        return redirect()->back()->with('success', 'Annonce remontée avec succès');
    }
}
