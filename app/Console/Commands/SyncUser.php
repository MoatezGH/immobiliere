<?php

namespace App\Console\Commands;

use App\Models\Property;
use App\Models\SyncedAction;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use GuzzleHttp\Psr7\Utils;
use function PHPUnit\Framework\isEmpty;

class SyncUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:propertyuser';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'sync property user';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $properties = Property::where('synced', true)->where('state', "valid")->orderBy("created_at", "asc")->limit(1)->get();
        // dd(count($properties));
        // dd($properties);
        $apiKey = env('API_KEY_TWO');
        $client = new \GuzzleHttp\Client();
        $prod_url = "https://les-annonces.com.tn/";

        // dd($properties);
        if (count($properties) > 0) {
            foreach ($properties as  $property) {
                // echo "Property Index: " . $index . "\n";
                Log::info('Id Property ' . $property->id);
                $user = $property->user;
                $email = urldecode($user->email);
                // $email = "rahma.bacha317@gmail.com";

                $category = $user->checkType();
                // dd($category);
                Log::info('category  ' . $category);
                $userType = null;
                switch ($category) {
                    case 'company':
                        Log::info('start company:::company');
                        $userType = $user->company;
                        if ($userType) {
                            Log::info('end company:::company ' . $userType->id);
                        } else {
                            Log::warning('No company found for user ID: ' . $user->id);
                        }
                        break;
                
                    case 'particular':
                        Log::info('start particular:::particular');
                        $userType = $user->particular;
                        if ($userType) {
                            Log::info('end particular:::particular ' . $userType->id);
                        } else {
                            Log::warning('No particular found for user ID: ' . $user->id);
                        }
                        break;
                
                    default:
                        Log::warning('Unknown category: ' . $category);
                        break;
                }
                
                // dd($category);
                if (!$category) {
                    Log::info('Response from API for check category type ' . $category);
                    $property->update(['synced' => false]);
                    continue;
                }
                if (!$userType) {
                    Log::info('Response from API for check user type ');
                    $property->update(['synced' => false]);
                    continue;
                }
                // dd($userType);


                // print_r($phone);
                // print_r($mobile);
                // die();
                $url = $prod_url . 'api/users/check?email=' . urlencode($email);
                // echo $url; 
                Log::info('prod_url '  . $prod_url);
                // dd($url);
                try {
                    $response = $client->request('GET', $url, [
                        'headers' => [
                            'X-API-KEY' => $apiKey,
                        ],
                        'verify' => false, // Disable SSL verification
                    ]);
                    // dd($response);
                    $statusCode = $response->getStatusCode();
                    // dd($statusCode);
                    $responseBody = $response->getBody()->getContents();
                    // dd($responseBody);

                    $dataCheckUser = json_decode($responseBody, true);

                    Log::info('Response from API for check email ' . $email);
                    Log::info('Response from API for check email '  . $responseBody);
                    if ($statusCode == 200) {
                        // dd("200");
                        if ($dataCheckUser['exists'] == false) {
                            $userResponse = $client->request('POST', $prod_url . 'api/user/register', [
                                'headers' => [
                                    'X-API-KEY' => $apiKey, // Add your API key
                                ],
                                'form_params' => [
                                    'name' => $user->username,
                                    'email' => $email,

                                    'category' => $category,
                                    'password' => $user->password,
                                ],
                                'verify' => false,
                            ]);
                            // dd("eee");
                            $responseUserBody = $userResponse->getBody()->getContents();
                            // dd($responseUserBody);
                            $dataRegisterUser = json_decode($responseUserBody, true);
                            Log::info('Response from Create User '  . $dataRegisterUser);

                            // if($dataRegisterUser['status'])
                            $user_id = $dataRegisterUser['index'];
                        } else {
                            // dd("eee");
                            if ($dataCheckUser['exists'] == true) {

                                $user_id = $dataCheckUser['index'];
                            } else {
                                Log::info('Response user id property problem: ' . $dataCheckUser);
                                // dd($dataCheckUser);
                            }
                        }

                        // dd($user_id);
                        if ($user_id !== "") {


                            $propertyData = [
                                [
                                    'name' => 'token',
                                    'contents' => $property->token,
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
                                    'name' => 'operation_id',
                                    'contents' => $property->operation_id,
                                ],
                                [
                                    'name' => 'user_id',
                                    'contents' => $user_id,
                                ],
                                [
                                    'name' => 'category_id',
                                    'contents' => $property->category_id,
                                ],
                                [
                                    'name' => 'title',
                                    'contents' => $property->title,
                                ],
                                [
                                    'name' => 'description',
                                    'contents' => $property->description,
                                ],
                                [
                                    'name' => 'price',
                                    'contents' => $property->price,
                                ],
                                [
                                    'name' => 'display_price',
                                    'contents' => $property->display_price,
                                ],
                                [
                                    'name' => 'floor_area',
                                    'contents' => $property->floor_area,
                                ],
                                [
                                    'name' => 'plot_area',
                                    'contents' => $property->plot_area,
                                ],
                                [
                                    'name' => 'room_number',
                                    'contents' => $property->room_number,
                                ],
                                [
                                    'name' => 'living_room_number',
                                    'contents' => $property->living_room_number,
                                ],
                                [
                                    'name' => 'bath_room_number',
                                    'contents' => $property->bath_room_number,
                                ],
                                [
                                    'name' => 'kitchen_number',
                                    'contents' => $property->kitchen_number,
                                ],
                                [
                                    'name' => 'balcony',
                                    'contents' => $property->balcony,
                                ],
                                [
                                    'name' => 'terrace',
                                    'contents' => $property->terrace,
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
                                    'name' => 'floor_number',
                                    'contents' => $property->floor_number,
                                ],
                                [
                                    'name' => 'elevator',
                                    'contents' => $property->elevator,
                                ],
                                [
                                    'name' => 'air_conditioner',
                                    'contents' => $property->air_conditioner,
                                ],
                                [
                                    'name' => 'alarm_system',
                                    'contents' => $property->alarm_system,
                                ],
                                [
                                    'name' => 'wifi',
                                    'contents' => $property->wifi,
                                ],
                                [
                                    'name' => 'active',
                                    'contents' => $property->active,
                                ],
                                [
                                    'name' => 'state',
                                    'contents' => $property->state,
                                ],
                                [
                                    'name' => 'situation_id',
                                    'contents' => $property->situation_id,
                                ],
                                [
                                    'name' => 'swimming_pool',
                                    'contents' => $property->swimming_pool,
                                ],
                                [
                                    'name' => 'prixtotaol',
                                    'contents' => $property->prixtotaol,
                                ],
                                [
                                    'name' => 'etage',
                                    'contents' => $property->etage,
                                ],
                                [
                                    'name' => 'swimming_pool_col',
                                    'contents' => $property->swimming_pool_col,
                                ],
                                [
                                    'name' => 'heating',
                                    'contents' => $property->heating,
                                ],
                                [
                                    'name' => 'address',
                                    'contents' => $property->address,
                                ]
                            ];
                            // Log::info('Response user id property problem: ' . $dataCheckUser);
                            // dd($property->main_picture);
                            // Handle the main picture
                            if ($property->main_picture) {
                                $mainPicturePath = public_path('uploads/main_picture/images/properties/' . $property->main_picture->alt);
                                if (file_exists($mainPicturePath)) {
                                    $propertyData[] = [
                                        'name'     => 'photos_main',
                                        'contents' => Utils::tryFopen($mainPicturePath, 'r'),
                                        'filename' => basename($mainPicturePath),
                                    ];
                                }
                            }
                            if (count($property->pictures) >= 0) {
                                foreach ($property->pictures as $index => $picture) {
                                    $imagePath = public_path('uploads/property_photo/' . $picture->alt);
                                    if (file_exists($imagePath)) {
                                        $propertyData[] = [
                                            'name'     => "photos_multiple[$index]",
                                            'contents' => Utils::tryFopen($imagePath, 'r'),
                                            'filename' => basename($imagePath),
                                        ];
                                    }
                                }
                            }
                            // dd($propertyData);


                            $propertyResponse = $client->request('POST', $prod_url . 'api/add/property', [
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
                            Log::info('Response Body create property: ' . $responseBodyproperty);

                            if ($dataAddproperty['success']) {
                                // Success is true
                                // Do something here
                                // dd($statusCode);
                                $property->update(['synced' => false]);
                                Log::info('success for :' . $property->id);
                            }
                        } else {

                            Log::info('Error for create property raison user id empty:' . $user_id);
                        }
                    } else {
                        Log::info('Response from API for url ' . $url);
                    }
                } catch (\GuzzleHttp\Exception\RequestException $e) {
                    // Handle request error and log it

                    // dd($e->getMessage());
                    $property->update(['synced' => false]);
                    //dd("e");
                    Log::error('Error for All API property '  . $e->getMessage());
                    Log::error('Error for property ID'  . $property->id);
                }
            }
        } else {
            Log::info('Count  ' . count($properties));

            Log::info('NO ITEM PROPERTY FOR PUBLISH  ');
        }
    }
}
