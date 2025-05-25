<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class UpdateDbController extends Controller
{
    function saveServiceCategories() {
        $categories = [
            'oui','non','a convenir'
        ];
    
        foreach ($categories as $category) {
            DB::table('service_types')->insert([
                'name' => $category,
                'type'=>'payement_type'
                // 'created_at' => now(),
                // 'updated_at' => now(),
            ]);
        }
    }
}