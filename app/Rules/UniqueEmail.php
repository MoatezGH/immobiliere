<?php

namespace App\Rules;

use Closure;
// use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Validation\Rule;

// class UniqueEmail implements ValidationRule
// {
//     /**
//      * Run the validation rule.
//      *
//      * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
//      */
//     public function validate(string $attribute, mixed $value, Closure $fail): void
//     {
//         //
//     }
// }

class UniqueEmail implements Rule
{
    public function passes($attribute, $value)
    {
        // dd($value);
        $userExists = DB::table('users')->where('email', $value)->exists();
        
        $classifiedUserExists = DB::table('classified_users')->where('email', $value)->exists();

        $serviceUserExists = DB::table('service_users')->where('email', $value)->exists();

        return !$userExists && !$classifiedUserExists && !$serviceUserExists;
    }

    public function message()
    {
        return 'L\'email existe déjà';
    }
}
