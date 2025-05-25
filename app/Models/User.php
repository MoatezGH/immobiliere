<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Logo;
use App\Models\Company;
use App\Models\Property;
use App\Models\Promoteur;
use App\Models\Particular;
use App\Models\PromoteurProperty;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use App\Notifications\CustomResetPassword;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'username',
        'email',
        'password',
        'enabled',
        'company_id',
        'particular_id',
        'promoteur_id',
        'store_id',
        'is_promoteur',
        // 'logo'=>this->logo(),
        // 'category'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * 
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new CustomResetPassword($token));
    }



    //delete properties
    public static function boot()
    {
        parent::boot();

        static::deleting(function ($user) {
            // Delete user properties
            if($user->isParticular() || $user->isCompany()){
                // die("1");
                foreach ($user->properties as $property) {
                    $property->delete();
                }
            }elseif($user->isPromoteur()){

                foreach ($user->promoteur_properties as $property) {
                    $property->delete();
                }
            }
if($user->store){
    $user->store->delete();

}
            
        });
    }
    //end delete property
    /**
     * Undocumented function
     *
     * @return void
     */
    public function company()
    {
        // return $this->hasOne(Company::class, "user_id");
        return $this->hasOne(Company::class);
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function logo()
    {
        // return $this->hasOne(Logo::class);
        // if (auth()) {

        $userType = auth()->user()->checkType();
        // dd($userType);

        switch ($userType) {
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
        if ($userType != "admin") {
            $logo = Logo::find($user->logo_id);
        } else {
            $logo = new logo;
        }
        return $logo;

        // }
    }


    public function promoteur_properties()
    {
        return $this->hasmany(PromoteurProperty::class, 'user_id');
    }
    /**
     * Undocumented function
     *
     * @return void
     */
    public function properties()
    {
        return $this->hasmany(Property::class, 'user_id');
    }
    /**
     * Undocumented function
     *
     * @return void
     */
    public function promoteur()
    {
        return $this->hasOne(Promoteur::class);
    }

    /**
     * 
     */
    public function particular()
    {
        return $this->hasOne(Particular::class);
    }

    /**
     * *
     *
     * @return void
     */
    public function store()
    {
        return $this->hasOne(Store::class);
    }

    /**
     * Undocumented function
     *
     * @return boolean
     */
    public function isCompany(): bool
    {
        return $this->company_id !== null && $this->company_id !== 0;
    }

    /**
     * Undocumented function
     *
     * @return boolean
     */
    public function isPromoteur(): bool
    {
        return $this->promoteur_id !== null && $this->company_id !== 0;
    }

    /**
     * Undocumented function
     *
     * @return boolean
     */
    public function isParticular(): bool
    {
        return $this->particular_id !== null && $this->company_id !== 0;
    }
    /**
     * Undocumented function
     *
     * @return boolean
     */
    public function isAdmin(): bool
    {
        return $this->is_admin == 1;
    }


    /**
     * Undocumented function
     *
     * @return void
     */
    public function checkType()
    {
        if ($this->isCompany()) {
            return "company";
        } elseif ($this->isPromoteur()) {
            return "promoteur";
        } elseif ($this->isAdmin()) {
            return "admin";
        } else {
            return "particular";
        }
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function userPhone()
    {
        $userType = $this->checkType();
        switch ($userType) {
            case 'company':
                $user = $this->company;
                break;
            case 'particular':
                $user = $this->particular;
                break;
            default:
                $user = $this->promoteur;
                break;
        }
        // Check if $user is not null before accessing its properties
        if ($user) {
            $phone = $user->phone ?? ''; // If $user->phone is null, use an empty string as the default value
            $mobile = $user->mobile ?? ''; // If $user->mobile is null, use an empty string as the default value
            $tel1 = $mobile . " / " . $phone;
            $tel = $tel1;

            return $tel;
        } else {
            // Handle the case where $user is null
            return " ";
        }
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function userPhone2()
    {
        $userType = $this->checkType();
        $user = null;
        $tel = '';

        switch ($userType) {
            case 'company':
                $user = $this->company()->first();
                if ($user) {
                    $tel = $user->mobile . "/" . $user->phone;
                }
                break;
            case 'particular':
                $user = $this->particular()->first();
                if ($user) {
                    $tel = $user->mobile . "/" . $user->phone;
                }
                break;
            default:
                $user = $this->promoteur()->first();
                if ($user) {
                    $tel = $user->phone . "/" . $user->mobile;
                }
                break;
        }

        return  $tel;
    }


    /**
     * Undocumented function
     *
     * @return void
     */
    public function userTypeName()
    {
        $userType = $this->checkType();
        switch ($userType) {
            case 'company':
                $user = $this->company;
                $user_name = $user->corporate_name ?? '';
                break;
            case 'particular':
                $user = $this->particular;
                $user_name = ($user->first_name ?? '') . ' ' . ($user->last_name ?? '');

                break;
            default:
                $user = $this->promoteur;
                $user_name = ($user->first_name ?? '') . ' ' . ($user->last_name ?? '');

                break;
        }

        // Check if $user is not null before accessing its properties
        if ($user) {

            return $user_name;
        } else {
            // Handle the case where $user is null
            return $this->username;
        }
    }


    /**
     * Undocumented function
     *
     * @return void
     */
    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function getLogo()
    {
        if ($this->store) {
            return $this->store->logo;
        }

        return null; // or return a default logo URL like 'default_logo.png'
    }
}
