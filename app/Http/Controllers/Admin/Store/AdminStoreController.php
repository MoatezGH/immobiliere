<?php

namespace App\Http\Controllers\Admin\Store;

use App\Models\Store;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminStoreController extends Controller
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
    public function index(Request $request){
        $query = Store::query();

        if ($request->filled('user_name')) {
            $userName = $request->input('user_name');
            // dd($userName );
            $query->whereHas('user', function ($query) use ($userName) {
                $query->where(
                    'username',
                    'like',
                    '%' . $userName . '%'
                );
            });
            // dd($query);
        }
        if ($request->filled('status')) {
            // dd($request->status);
            $query->where(
                'status',
                $request->status
            );
            // dd($query);
        }
        $stores=$query->orderBy('created_at', 'desc')->paginate(12);
        return view('dashboard_admin.stores.index',compact('stores'));
    }

    public function active(Store $store)
    {
        // dd($user);
        try {
            $store->status = 1;
            $store->save();
            return redirect()->back()->with('success', 'Store a été activé avec succès.');
        } catch (\Exception $e) {
            // Log::error('Error disabling user: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Opération a échoué.');
        }
    }

    public function inactive(Store $store)
    {
        // dd($user);
        try {
            $store->status = 0;
            $store->save();
            return redirect()->back()->with('success', 'Store a été bloqué avec succès.');
        } catch (\Exception $e) {
            // Log::error('Error disabling user: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Opération a échoué..');
        }
    }
}
