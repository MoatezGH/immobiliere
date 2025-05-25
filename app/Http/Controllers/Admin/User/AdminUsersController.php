<?php

namespace App\Http\Controllers\Admin\User;


use App\Models\City;
use App\Models\User;
use App\Models\Service;
use App\Models\Category;
use App\Models\Property;
use App\Models\Classified;
use App\Models\ServiceUser;
use Illuminate\Http\Request;
use App\Models\ClassifiedUser;
use App\Models\PromoteurProperty;
use App\Models\Property_features;
use App\Http\Controllers\Controller;

class AdminUsersController extends Controller
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
        // dd($request->all());
        // $users = User::where("administrator_id", null)->paginate(10);
        $categories = Category::all();
        $cities = City::all();


        $query = User::where("administrator_id", null);
        if ($request->type == "promoteur") {
            $query = User::where('is_admin', 0)
                ->where('is_promoteur', 1)
                ->with('promoteur');
        } elseif ($request->type == "particulier") {
            $query = User::where('is_admin', 0)
                ->where('is_promoteur', 0)
                ->where('particular_id', '!=', 0)
                ->whereNotNull('particular_id');
        } elseif ($request->type == "entreprise") {
            $query = User::where('is_admin', 0)
                ->where('is_promoteur', 0)
                ->where('company_id', '!=', 0)
                ->whereNotNull('company_id');
        }
        $searchfield = "";
        $datefield = "";
        $statusfield = "";

        // Apply filters
        if ($request->filled('search')) {
            $searchfield = trim($request->input('search'));
            // dd($request->all());

            $query->where(function ($q) use ($searchfield) {
                $q->where('username', 'like', '%' . $searchfield . '%')
                    ->orWhere('email', 'like', '%' . $searchfield . '%');
                // $q->where('username', $search)
                //     ->orWhere('email', $search);
                // dd($q);

            });
        }

        if ($request->filled('status')) {
            $statusfield = $request->input('status');
            $query->where('enabled', $statusfield);
        }

        if ($request->filled('date')) {
            $created_at = $request->input('date');

            $startOfDay = date('Y-m-d 00:00:00', strtotime($created_at));
            $endOfDay = date('Y-m-d 23:59:59', strtotime($created_at));
            // dd($startOfDay);
            $query->where('created_at', '>=', $startOfDay)
                ->where('created_at', '<=', $endOfDay);
        }

        $query->orderBy('created_at', 'desc');

        $users = $query->paginate(10);

        return view("dashboard_admin.users.index", compact("users", "categories", 'searchfield', 'statusfield'));
    }

    public function disable(User $user)
    {
        // dd($user);
        try {
            if ($user->enabled == 0) {
                return redirect()->back()->with('error', ' L\'utilisateur est deja bloqué.');
            }
            $user->enabled = 0;
            $user->save();
            return redirect()->back()->with('success', 'l\'utilisateur a été bloqué avec succès.');
        } catch (\Exception $e) {
            // Log::error('Error disabling user: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Échec du bloqué ce l\'utilisateur.');
        }
    }

    public function active(User $user)
    {
        // dd($user);
        try {

            $user->enabled = 1;
            $user->save();
            return redirect()->back()->with('success', 'L\'utilisateur a été activé avec succès.');
        } catch (\Exception $e) {
            // Log::error('Error disabling user: ' . $e->getMessage());
            return redirect()->back()->with('error', 'L\'activation de l\'utilisateur a échoué.');
        }
    }

    public function delete(User $user)
    {


        try {


            if (!auth()->user()->isAdmin()) {
                return redirect()->back()->with('error', 'Tu n\'as pas la permission.');
            }

            if ($user->checkType() != "promoteur") {
                $propertyIds = Property::where('user_id', $user->id)->pluck('id');
                // dd(Property_features::whereIn('property_id', $propertyIds)->get());

                // Delete all related property features in a single query
                Property_features::whereIn('property_id', $propertyIds)
                    ->where('type__', 'property')
                    ->delete();

                // Delete all properties in a single query
                Property::whereIn('id', $propertyIds)->delete();
            } else {
                $propertyIds = PromoteurProperty::where('user_id', $user->id)->pluck('id');

                // Delete all related property features in a single query
                Property_features::whereIn('property_id', $propertyIds)
                    ->where('type__', 'promoteur_property')
                    ->delete();

                // Delete all properties in a single query
                PromoteurProperty::whereIn('id', $propertyIds)->delete();
            }

            $user->delete();
            return redirect()->back()->with('success', 'L\'utilisateur a été supprimé avec succès.');
        } catch (\Exception $e) {
            // Log::error('Error disabling user: ' . $e->getMessage());
            return redirect()->back()->with('error', 'La suppression de l\'utilisateur a échoué.');
        }
    }

    public function get_all_clasified_users(Request $request)
    {
        try {
            // $users = ClassifiedUser::paginate(12);
            // dd($users);

            $query = ClassifiedUser::orderBy('created_at');
            // dd($users);
            if ($request->filled('search')) {
                $searchfield = trim($request->input('search'));
                // dd($request->all());
                // dd($searchfield);
    
                $query->where(function ($q) use ($searchfield) {
                    $q->where('full_name', 'like', '%' . $searchfield . '%')
                        ->orWhere('email', 'like', '%' . $searchfield . '%');
                    // dd($q);
    
                });
            }

            if ($request->filled('date')) {
                $created_at = $request->input('date');
    
                $startOfDay = date('Y-m-d 00:00:00', strtotime($created_at));
                $endOfDay = date('Y-m-d 23:59:59', strtotime($created_at));
                // dd($startOfDay);
                $query->where('created_at', '>=', $startOfDay)
                    ->where('created_at', '<=', $endOfDay);
            }

            if ($request->filled('status')) {
                $statusfield = $request->input('status');
                $query->where('enabled', $statusfield);
            }
            
            $users = $query->paginate(10);

            return view('dashboard_admin.users_classifieds.index', compact("users"));
        } catch (\Throwable $e) {
            return redirect()->back();
        }
    }


    public function get_all_services_users(Request $request)
    {
        try {
            // dd($request->all());
            $query = ServiceUser::orderBy('created_at');
            // dd($users);
            if ($request->filled('search')) {
                $searchfield = trim($request->input('search'));
                // dd($request->all());
                // dd($searchfield);
    
                $query->where(function ($q) use ($searchfield) {
                    $q->where('full_name', 'like', '%' . $searchfield . '%')
                        ->orWhere('email', 'like', '%' . $searchfield . '%');
                    // dd($q);
    
                });
            }

            if ($request->filled('date')) {
                $created_at = $request->input('date');
    
                $startOfDay = date('Y-m-d 00:00:00', strtotime($created_at));
                $endOfDay = date('Y-m-d 23:59:59', strtotime($created_at));
                // dd($startOfDay);
                $query->where('created_at', '>=', $startOfDay)
                    ->where('created_at', '<=', $endOfDay);
            }

            if ($request->filled('status')) {
                $statusfield = $request->input('status');
                $query->where('enabled', $statusfield);
            }

            $users = $query->paginate(10);
            return view('dashboard_admin.users_service.index', compact("users"));
        } catch (\Throwable $e) {
            return redirect()->back();
        }
    }


    public function deleteUserService($id)
    {
        // dd($id);

        try {

            if (!auth()->user()->isAdmin()) {
                return redirect()->back()->with('error', 'Tu n\'as pas la permission.');
            }
            $user = ServiceUser::find($id);
            // dd($user);
            if (!$user) {
                return redirect()->back()->with('error', 'Utilisateur non trouvé');
            }

            $propertyIds = Service::where('user_id', $user->id)->pluck('id');
            // dd(Property_features::whereIn('property_id', $propertyIds)->get());

            // Delete all related property features in a single query
            Property_features::whereIn('property_id', $propertyIds)
                ->where('type__', 'service')
                ->delete();

            // Delete all properties in a single query
            Service::whereIn('id', $propertyIds)->delete();


            $user->delete();
            return redirect()->back()->with('success', 'L\'utilisateur a été supprimé avec succès.');
        } catch (\Exception $e) {
            // Log::error('Error disabling user: ' . $e->getMessage());
            return redirect()->back()->with('error', 'La suppression de l\'utilisateur a échoué.');
        }
    }



    public function disableServiceClassified(Request $request,$user_id)
    {
        // dd($request->type);
        try {
            if($request->type == "classified"){
                $user=ClassifiedUser::find($user_id);
            }elseif($request->type == "service"){
                $user=ServiceUser::find($user_id);

            }
            // dd($user);
            if (!$user) {
                return redirect()->back()->with('error', ' Problem connexion.');
            }
            if ($user->enabled == 0) {
                return redirect()->back()->with('error', ' L\'utilisateur est deja bloqué.');
            }
            $user->enabled = 0;
            $user->save();
            return redirect()->back()->with('success', 'l\'utilisateur a été bloqué avec succès.');
        } catch (\Exception $e) {
            // Log::error('Error disabling user: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Échec du bloqué ce l\'utilisateur.');
        }
    }


    public function activeServiceClassified(Request $request,$user_id)
    {
        // dd($user);
        try {

            if($request->type == "classified"){
                $user=ClassifiedUser::find($user_id);
            }elseif($request->type == "service"){
                $user=ServiceUser::find($user_id);

            }
            // dd($user);
            if (!$user) {
                return redirect()->back()->with('error', ' Problem connexion.');
            }

            $user->enabled = 1;
            $user->save();
            return redirect()->back()->with('success', 'L\'utilisateur a été activé avec succès.');
        } catch (\Exception $e) {
            // Log::error('Error disabling user: ' . $e->getMessage());
            return redirect()->back()->with('error', 'L\'activation de l\'utilisateur a échoué.');
        }
    }


    public function deleteServiceClassified(Request $request,$user_id)
    {
// dd($request->type);

        try {


            if (!auth()->user()->isAdmin()) {
                return redirect()->back()->with('error', 'Tu n\'as pas la permission.');
            }

            if($request->type == "classified") {
                $user=ClassifiedUser::find($user_id);
// dd($user);
                $propertyIds = Classified::where('user_id', $user->id)->pluck('id');
                // dd(Property_features::whereIn('property_id', $propertyIds)->get());

                // Delete all related property features in a single query
                Property_features::whereIn('property_id', $propertyIds)
                    ->where('type__', 'classified')
                    ->delete();

                // Delete all properties in a single query
                Classified::whereIn('id', $propertyIds)->delete();
            } elseif($request->type == "service") {
                $user=ServiceUser::find($user_id);

                $propertyIds = Service::where('user_id', $user->id)->pluck('id');

                // Delete all related property features in a single query
                Property_features::whereIn('property_id', $propertyIds)
                    ->where('type__', 'service')
                    ->delete();

                // Delete all properties in a single query
                Service::whereIn('id', $propertyIds)->delete();
            }

            $user->delete();
            return redirect()->back()->with('success', 'L\'utilisateur a été supprimé avec succès.');
        } catch (\Exception $e) {
            // Log::error('Error disabling user: ' . $e->getMessage());
            return redirect()->back()->with('error', 'La suppression de l\'utilisateur a échoué.');
        }
    }


    public function access_to_publish(User $user)
    {
        // dd($user);
        try {
            if($user->access_to_publish != 1){
                $user->access_to_publish = 1;
                $user->save();
                return redirect()->back()->with('success', 'L\'utilisateur a été l\'accés de publier sur '.env("DEUXIEM_SITE"));
            }
            $user->access_to_publish = 0;
                $user->save();
                return redirect()->back()->with('success', 'L\'utilisateur a été bloqué l\'accés pour publier sur '.env("DEUXIEM_SITE"));
        } catch (\Exception $e) {
            // Log::error('Error disabling user: ' . $e->getMessage());
            return redirect()->back()->with('error', 'L\'activation de l\'accessé a échoué.');
        }
    }
}
