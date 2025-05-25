<?php

namespace App\Http\Controllers\Immo;

use App\Models\User;
use App\Models\Store;
use App\Models\Company;
use App\Models\Category;
use App\Models\Promoteur;
use App\Models\Particular;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\RequestImmoRegister;

class AuthImmoController extends Controller
{
    public function register(RequestImmoRegister $request)
    {
        // dd(new Store);
        try {
            $user = User::create([
                'username' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'enabled' => "1",

            ]);

            if (!$user) {
                // throw new Exception('User creation failed.'); // Handle user creation errors gracefully

                return redirect()->back()->withErrors(['register' => 'User creation failed']);
            }

            // Handle company registration for 'entreprise' category securely
            if ($request['category'] === 'entreprise') {
                $user_company = Company::create([
                    "user_id" => $user->id,
                    "corporate_name" => $request->name, // Use validated name for consistency
                    "category" => "Agence immobilière",
                ]);

                if (!$user_company) {
                    // throw new Exception('Company creation failed.'); // Handle company creation errors gracefully
                    return redirect()->back()->withErrors(['register' => 'Company creation failed']);
                }
                $store_company = Store::create([
                    "user_id" => $user->id,
                    'store_name' => $request->name,
                    'store_email' => $request->email,
                    'type' => 'company',
                    'slug' => Str::slug($request->name . random_int(5, 9999))
                ]);

                if (!$store_company) {
                    // throw new Exception('promoteur creation failed.');
                    return redirect()->back()->withErrors(['register' => 'Une création de store a échoué']);
                    // Handle company creation errors gracefully
                }


                // Update user with company ID only after successful company creation
                $update_user = $user->update([
                    "company_id" => $user_company->id,
                    "store_id" => $store_company->id,
                ]);
                if (!$update_user) {
                    // throw new Exception('user not updat.'); // Handle company creation errors gracefully
                    return redirect()->back()->withErrors(['register' => 'user not updat']);
                }
            }

            // Handle company registration for 'Particular' category securely
            if ($request['category'] === 'particulier') {
                // dd('test');
                $fullName = $request->name;

                try {
                    $nameParts = explode(" ", $fullName);
                    $firstName = $nameParts[0];
                    $lastName = isset($nameParts[1]) ? $nameParts[1] : " "; // Set lastName to null if not available
                } catch (Exception $e) {
                    // Log::error('Registration failed: ' . $e->getMessage());
                    return redirect()->back()->withErrors(['register' => 'Échec de l\'enregistrement']);
                }
                if (empty($lastName)) {
                    $lastName = "";
                }

                $user_particular = Particular::create([
                    "user_id" => $user->id,
                    'first_name' => $firstName,
                    'last_name' => $lastName,
                ]);

                if (!$user_particular) {
                    // throw new Exception('Particular creation failed.');
                    return redirect()->back()->withErrors(['register' => 'Une création particulière a échoué']);
                    // Handle company creation errors gracefully
                }
                $store_particular = Store::create([
                    "user_id" => $user->id,
                    'store_name' => $request->name,
                    'store_email' => $request->email,
                    'type' => 'particulier',
                    'slug' => Str::slug($request->name . random_int(5, 9999))
                ]);

                if (!$store_particular) {
                    // throw new Exception('promoteur creation failed.');
                    return redirect()->back()->withErrors(['register' => 'Une création de store a échoué']);
                    // Handle company creation errors gracefully
                }

                // Update user with company ID only after successful company creation
                $update_user = $user->update([
                    "particular_id" => $user_particular->id,
                    "store_id" => $store_particular->id,

                ]);
                if (!$update_user) {
                    return redirect()->back()->withErrors(['register' => 'l\'utilisateur ne met pas à jour']);
                }
            }

            // Handle company registration for 'Particular' category securely
            if ($request['category'] === 'promoteur') {
                $fullName = $request->name;

                try {
                    $nameParts = explode(" ", $fullName);
                    $firstName = $nameParts[0];
                    $lastName = isset($nameParts[1]) ? $nameParts[1] : null; // Set lastName to null if not available
                } catch (Exception $e) {
                    // Log::error('Registration failed: ' . $e->getMessage());
                    return redirect()->back()->withErrors(['register' => 'Échec de l\'enregistrement']);
                }


                $user_promoteur = Promoteur::create([
                    "user_id" => $user->id,
                    'first_name' => $firstName,
                    'last_name' => $lastName,


                ]);

                if (!$user_promoteur) {
                    // throw new Exception('promoteur creation failed.');
                    return redirect()->back()->withErrors(['register' => 'Une création particulière a échoué']);
                    // Handle company creation errors gracefully
                }

                $store_promoteur = Store::create([
                    "user_id" => $user->id,
                    'store_name' => $request->name,
                    'store_email' => $request->email,
                    'type' => 'promoteur',
                    'slug' => Str::slug($request->name . random_int(5, 9999))
                ]);

                if (!$store_promoteur) {
                    // throw new Exception('promoteur creation failed.');
                    return redirect()->back()->withErrors(['register' => 'Une création de store a échoué']);
                    // Handle company creation errors gracefully
                }

                // Update user with company ID only after successful company creation
                $update_user = $user->update([
                    "promoteur_id" => $user_promoteur->id,
                    "is_promoteur" => 1,

                    "store_id" => $store_promoteur->id,

                ]);
                if (!$update_user) {
                    return redirect()->back()->withErrors(['register' => 'l\'utilisateur ne met pas à jour']);
                }
            }

            // Authenticate the user securely
            Auth::guard()->login($user);

            return redirect()->route('profile_annonceur_immobilier');
        } catch (Exception $e) {
            // Log the error for security analysis
            // Log::error('Registration failed: ' . $e->getMessage());

            // Return a generic error message to avoid revealing specific details
            return redirect()->back()->withErrors(['register' => 'Échec de l\'enregistrement. Veuillez réessayer']);
        }
    }



    public function showRegistrationForm()
    {
        $types = array();
        $types['entreprise'] = "Entreprise (Payant voir les packs)";
        $types['particulier'] = "Particulier (Gratuit)";
        $types['promoteur'] = "Promoteur (Payant voir les packs)";
        $categories = Category::all();
        return view('auth.register', compact('categories', 'types'));
    }


    public function signOut()
    {
        Session::flush();
        Auth::logout();

        return Redirect('login');
    }
}
