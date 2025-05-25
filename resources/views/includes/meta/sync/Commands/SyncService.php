<?php

namespace App\Console\Commands;

use App\Models\Service;
use Illuminate\Console\Command;
// use Illuminate\Support\Facades\Http;
use App\Models\SyncedAction;
use Illuminate\Support\Facades\Log;
use GuzzleHttp\Psr7\Utils;

class SyncService extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:services';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'add service';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Fetch services that need to be synced (unsynced ones)
        $services = Service::where('synced', true)->where('status', 1)->orderBy("created_at","asc")->limit(1)->get();
        // dd($services);
        $apiKey = env('API_KEY_TWO');

        $client = new \GuzzleHttp\Client();
        $dev_url = "http://127.0.0.1:8000/";
        $prod_url = "https://les-annonces.com.tn/";
        if (count($services) > 0) {
            foreach ($services as $service) {
                $user = $service->user;
                $email = urldecode($user->email);
                try {

                    $response = $client->request('GET', $prod_url . 'api/users/service/check', [
                        'headers' => [
                            'X-API-KEY' => $apiKey,
                        ],
                        'query' => [
                            'email' => $email,
                        ],
                        'verify' => false, // Disable SSL verification
                    ]);

                    $statusCode = $response->getStatusCode();
Log::info('Status code check user service' . $statusCode);
                    $responseBody = $response->getBody()->getContents();

                    $dataCheckUser = json_decode($responseBody, true);
                    // dd($dataCheckUser);
                    //Log::info('Response from API for check email ' . $email . ': ' . $dataCheckUser);

                    if ($statusCode == 200) {
                        if ($dataCheckUser['exists'] == false) {

                            $userResponse = $client->request('POST', $prod_url . 'api/register/service', [
                                'headers' => [
                                    'X-API-KEY' => $apiKey, // Add your API key
                                ],
                                'form_params' => [
                                    'full_name' => $user->full_name,
                                    'email' => $user->email,
                                    'phone' => $user->phone,
                                    // 'full_name' => $user->full_name,
                                    // 'email' => $user->email,
                                    // 'phone' => $user->phone,
                                    
                                    'city_id' => $user->city_id,
                                    'country_id' => $user->country_id,
                                    
                                    'address' => $user->address,
                                    'password' => $user->password,
                                    // 'password' => $user->password, // Ensure the password is hashed before sending
                                ],
                                'verify' => false, // Disable SSL verification if needed
                            ]);
                            $statusCodeRegister = $userResponse->getStatusCode();
Log::info('Status code register user service' . $statusCodeRegister);
                            // dd($userResponse);

                            $responseRegisterBody = $userResponse->getBody()->getContents();
                            $dataRegisterUser = json_decode($responseRegisterBody, true);
                            // dd($dataRegisterUser);
                            //Log::info('Response from API create service '  . $dataRegisterUser);

                            // if($dataRegisterUser['status'])
                            $user_id = $dataRegisterUser['index'];
                            // dd($dataRegisterUser['index']);
                        } else {
                            if ($dataCheckUser['exists'] == true) {

                                $user_id = $dataCheckUser['index'];
                            } else {
                                Log::info('Response user id service problem: ' . $dataCheckUser);
                                //dd($dataCheckUser);
                            }
                        }

                        if ($user_id !== "") {
                            $serviceData = [
                                [
                                    'name'     => 'title',
                                    'contents' => $service->title,
                                ],
                                [
                                    'name'     => 'category_id',
                                    'contents' => $service->category_id,
                                ],
                                [
                                    'name'     => 'service',
                                    'contents' => $service->service,
                                ],
                                [
                                    'name'     => 'city_id',
                                    'contents' => $service->city_id,
                                ],
                                [
                                    'name'     => 'work_zone',
                                    'contents' => $service->work_zone,
                                ],
                                [
                                    'name'     => 'annonceur_type',
                                    'contents' => $service->annonceur_type,
                                ],
                                [
                                    'name'     => 'type',
                                    'contents' => $service->type,
                                ],
                                [
                                    'name'     => 'description',
                                    'contents' => $service->description ?? "",
                                ],
                                [
                                    'name'     => 'user_id',
                                    'contents' => $user_id,
                                ],
                                [
                                    'name'     => 'ref',
                                    'contents' => uniqid(),
                                ],
                                [
                                    'name'     => 'status',
                                    'contents' => $service->status,
                                ],
                                [
                                    'name'     => 'paiement_type',
                                    'contents' => $service->paiement_type,
                                ]
                                // Add other classified fields here
                            ];

                            // Handle the main picture
                            if ($service->mainPicture) {
                                $mainPicturePath = public_path('uploads/service/main_picture/' . $service->mainPicture->picture_path);
                                if (file_exists($mainPicturePath)) {
                                    $serviceData[] = [
                                        'name'     => 'main_picture',
                                        'contents' => Utils::tryFopen($mainPicturePath, 'r'),
                                        'filename' => basename($mainPicturePath),
                                    ];
                                }
                            }

                            if (count($service->pictures) >= 0) {
                                foreach ($service->pictures as $index => $picture) {
                                    $imagePath = public_path('uploads/service/multi_images/' . $picture->picture_path);
                                    if (file_exists($imagePath)) {
                                        $serviceData[] = [
                                            'name'     => "images[$index]",
                                            'contents' => Utils::tryFopen($imagePath, 'r'),
                                            'filename' => basename($imagePath),
                                        ];
                                    }
                                }
                            }

                            $serviceResponse = $client->request('POST', $prod_url . 'api/add/service', [
                                'headers' => [
                                    'X-API-KEY' => $apiKey,
                                ],
                                'multipart' => $serviceData,
                                // Guzzle handles file uploads with 'multipart'
                                'verify' => false,  // Disable SSL verification if needed
                            ]);

                            $statusCode = $serviceResponse->getStatusCode();  // Expect 200 for success
                            $responseBodyservice = $serviceResponse->getBody()->getContents();
                            $dataAddservice = json_decode($responseBodyservice, true); // Should be "good"
                            //dd($dataAddClassified);
                            // Log the status code and response body
                            Log::info('Status Code add service: ' . $statusCode);
                            Log::info('Response Body create service: ' . $responseBodyservice);

                            if ($dataAddservice['success']) {
                                // Success is true
                                // Do something here
                                // dd($statusCode);
                                $service->update(['synced' => false]);
                            }
                        }else {
                            Log::info('Error for create service raison user id empty:' . $user_id);
                        }
                    }
                } catch (\GuzzleHttp\Exception\RequestException $e) {
                    // Handle request error and log it

                    //dd($e->getMessage());

                    Log::error('Error for All API Classified '  . $e->getMessage());
                }

            }
        }else{
            Log::info('NO ITEM SERVICE FOR PUBLISH  ' );
        }
    }
}
