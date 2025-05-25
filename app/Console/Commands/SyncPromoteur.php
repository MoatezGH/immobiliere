<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\PromoteurProperty;
use Illuminate\Support\Facades\Http;
use App\Models\SyncedAction;
use Illuminate\Support\Facades\Log;
use GuzzleHttp\Psr7\Utils;

class SyncPromoteur extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:promoteur';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'sync property promoteur';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $properties = PromoteurProperty::where('synced', true)->where('status', 1)->orderBy("created_at","asc")->limit(3)->get();
        $apiKey = env('API_KEY_TWO');
        $client = new \GuzzleHttp\Client();
        $prod_url = "https://les-annonces.com.tn/";
        // dd(count($properties));
        if (count($properties) > 0) {
            foreach ($properties as  $property) {
                $user = $property->user;
                // dd($user);
                $email = urldecode($user->email);


                // $email = "he@jj.com";
                $userType = $user->promoteur;

                if (!$userType) {
                    Log::info('Response from API for check user type ' . $userType);
                    continue;
                }
                // dd($userType);
                $phone = $userType->mobile;
                $mobile = $userType->phone;


                $url = $prod_url . 'api/users/check?email=' . urlencode($email);
                try {
                    $response = $client->request('GET', $url, [
                        'headers' => [
                            'X-API-KEY' => $apiKey,
                        ],
                        'verify' => false, // Disable SSL verification
                    ]);

                    $statusCode = $response->getStatusCode();
Log::info('Status code check user promoteur');
                    // dd($statusCode);
                    $responseBody = $response->getBody()->getContents();

                    $dataCheckUser = json_decode($responseBody, true);
                    // dd($dataCheckUser);
                    Log::info('Response from API for check email Promoteur ');

                    if ($statusCode == 200) {
                        if ($dataCheckUser['exists'] == false) {
                            $userResponse = $client->request('POST', $prod_url . 'api/user/register', [
                                'headers' => [
                                    'X-API-KEY' => $apiKey, // Add your API key
                                ],
                                'form_params' => [
                                    'name' => $user->username,
                                    'email' => $email,
                                    'phone' => $phone,
                                    'mobile' => $mobile,
                                    'category' => "promoteur",
                                    'password' => $user->password,
                                ],
                                'verify' => false,
                            ]);
$statusCodeRegister = $response->getStatusCode();
Log::info('status code create user Promoteur '  );

                            $responseUserBody = $userResponse->getBody()->getContents();
                            // dd($responseUserBody);
                            $dataRegisterUser = json_decode($responseUserBody, true);
                            Log::info('Response from API Create User Promoteur'  );

                            // if($dataRegisterUser['status'])
                            $user_id = $dataRegisterUser['index'];

                            
                        } else {
                            if ($dataCheckUser['exists'] == true) {

                                $user_id = $dataCheckUser['index'];
                            } else {
                                Log::info('Response user Promoteur id service problem: ' );
                                //dd($dataCheckUser);
                            }
                        }

                        if ($user_id !== "") {

                            $propertyData = [
                                [
                                    'name' => 'title',
                                    'contents' => $property->title,
                                ],
                                [
                                    'name' => 'operation_id',
                                    'contents' => $property->operation_id,
                                ],
                                [
                                    'name' => 'category_id',
                                    'contents' => $property->category_id,
                                ],
                                [
                                    'name' => 'remise_des_clés',
                                    'contents' => $property->remise_des_clés,
                                ],
                                [
                                    'name' => 'active',
                                    'contents' => $property->active,
                                ],
                                [
                                    'name' => 'price_total',
                                    'contents' => $property->price_total,
                                ],
                                [
                                    'name' => 'price_metre',
                                    'contents' => $property->price_metre,
                                ],
                                [
                                    'name' => 'price_metre_terrasse',
                                    'contents' => $property->price_metre_terrasse,
                                ],
                                [
                                    'name' => 'price_metre_jardin',
                                    'contents' => $property->price_metre_jardin,
                                ],
                                [
                                    'name' => 'price_cellier',
                                    'contents' => $property->price_cellier,
                                ],
                                [
                                    'name' => 'price_parking',
                                    'contents' => $property->price_parking,
                                ],
                                [
                                    'name' => 'surface_totale',
                                    'contents' => $property->surface_totale,
                                ],
                                [
                                    'name' => 'surface_habitable',
                                    'contents' => $property->surface_habitable,
                                ],
                                [
                                    'name' => 'surface_terrasse',
                                    'contents' => $property->surface_terrasse,
                                ],
                                [
                                    'name' => 'surface_jardin',
                                    'contents' => $property->surface_jardin,
                                ],
                                [
                                    'name' => 'surface_cellier',
                                    'contents' => $property->surface_cellier,
                                ],
                                [
                                    'name' => 'city_id',
                                    'contents' => $property->city_id,
                                ],
                                [
                                    'name' => 'area_id',
                                    'contents' => $property->area_id,
                                ],
                                [
                                    'name' => 'user_id',
                                    'contents' => $user_id,
                                ],
                                [
                                    'name' => 'address',
                                    'contents' => $property->address,
                                ],
                                [
                                    'name' => 'description',
                                    'contents' => $property->description,
                                ],
                                [
                                    'name' => 'nb_bedroom',
                                    'contents' => $property->nb_bedroom,
                                ],
                                [
                                    'name' => 'nb_bathroom',
                                    'contents' => $property->nb_bathroom,
                                ],
                                [
                                    'name' => 'nb_kitchen',
                                    'contents' => $property->nb_kitchen,
                                ],
                                [
                                    'name' => 'nb_terrasse',
                                    'contents' => $property->nb_terrasse,
                                ],
                                [
                                    'name' => 'nb_etage',
                                    'contents' => $property->nb_etage,
                                ],
                                [
                                    'name' => 'nb_living',
                                    'contents' => $property->nb_living,
                                ],
                                [
                                    'name' => 'balcon',
                                    'contents' => $property->balcon,
                                ],
                                [
                                    'name' => 'garden',
                                    'contents' => $property->garden,
                                ],
                                [
                                    'name' => 'garage',
                                    'contents' => $property->garage,
                                ],
                                [
                                    'name' => 'parking',
                                    'contents' => $property->parking,
                                ],
                                [
                                    'name' => 'ascenseur',
                                    'contents' => $property->ascenseur,
                                ],
                                [
                                    'name' => 'heating',
                                    'contents' => $property->heating,
                                ],
                                [
                                    'name' => 'climatisation',
                                    'contents' => $property->climatisation,
                                ],
                                [
                                    'name' => 'system_alarm',
                                    'contents' => $property->system_alarm,
                                ],
                                [
                                    'name' => 'wifi',
                                    'contents' => $property->wifi,
                                ],
                                [
                                    'name' => 'piscine',
                                    'contents' => $property->piscine,
                                ],
                                [
                                    'name' => 'status',
                                    'contents' => $property->status,
                                ],
                                [
                                    'name' => 'display_price',
                                    'contents' => $property->display_price,
                                ],
                                [
                                    'name' => 'publish_now',
                                    'contents' => $property->publish_now,
                                ],
                                [
                                    'name' => 'swimming_pool_public',
                                    'contents' => $property->swimming_pool_public,
                                ],
                                [
                                    'name' => 'salle_eau',
                                    'contents' => $property->salle_eau,
                                ],
                                [
                                    'name' => 'suite_parental',
                                    'contents' => $property->suite_parental,
                                ],
                                [
                                    'name' => 'split',
                                    'contents' => $property->split,
                                ]
                            ];

                            if ($property->getFirstImageOrDefault()) {
                                $mainPicturePath = public_path('uploads/promoteur_property/' . $property->getFirstImageOrDefault());
                                if (file_exists($mainPicturePath)) {
                                    $propertyData[] = [
                                        'name'     => 'photos_main',
                                        'contents' => Utils::tryFopen($mainPicturePath, 'r'),
                                        'filename' => basename($mainPicturePath),
                                    ];
                                }
                            }
                            /***** */
                            if ($property->vedio_path) {
                                $vedioPath = public_path('uploads/videos/properties_promoteur/' . $property->vedio_path);
                                if (file_exists($vedioPath)) {
                                    // $request_add_property->attach('video', fopen($vedioPath, 'r'), basename($vedioPath));

                                    $propertyData[] = [
                                        'name'     => 'video',
                                        'contents' => Utils::tryFopen($vedioPath, 'r'),
                                        'filename' => basename($vedioPath),
                                    ];
                                }
                            }

                            /******* */
                            if (count($property->images) >= 0) {
                                foreach ($property->images as $index => $picture) {
                                    $imagePath = public_path('uploads/promoteur_property/' . $picture->title);
                                    if (file_exists($imagePath)) {
                                        $propertyData[] = [
                                            'name'     => "photos_multiple[$index]",
                                            'contents' => Utils::tryFopen($imagePath, 'r'),
                                            'filename' => basename($imagePath),
                                        ];
                                    }
                                }
                            }

                            $propertyResponse = $client->request('POST', $prod_url . 'api/add/property/promoteur', [
                                'headers' => [
                                    'X-API-KEY' => $apiKey,
                                ],
                                'multipart' => $propertyData,
                                // Guzzle handles file uploads with 'multipart'
                                'verify' => false,  // Disable SSL verification if needed
                            ]);

                            $statusCode = $propertyResponse->getStatusCode();  // Expect 200 for success
                            $responseBodyproperty = $propertyResponse->getBody()->getContents();
                            // dd($responseBodyproperty);

                            $dataAddproperty = json_decode($responseBodyproperty, true); // Should be "good"
                            // dd($dataAddproperty);
                            // Log the status code and response body
                            Log::info('Status Code: ' . $statusCode);
                            Log::info('Response Body create property promoteur: ');
                            if ($dataAddproperty['success']) {
                                // Success is true
                                // Do something here
                                // dd($statusCode);
                                $property->update(['synced' => false]);
                            }
                        } else {

                            Log::info('Error for create property raison user id empty:' . $user_id);
                        }
                    }
                } catch (\GuzzleHttp\Exception\RequestException $e) {
                    // dd($e->getMessage());

                    Log::error('Error for All API property '  . $e->getMessage());
                }
                
            }
        }else{
            Log::info('NO ITEM PROMOTEUR FOR PUBLISH  ' );
        }
    }
}
