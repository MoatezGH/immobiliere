<?php

namespace App\Console\Commands;

use App\Models\Classified;
use App\Models\SyncedAction;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use GuzzleHttp\Psr7\Utils;

class SyncClassifieds extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:classifieds';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'add classifieds';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Fetch classifieds that need to be synced (unsynced ones)
        $classifieds = Classified::where('synced', true)->where('status', 1)->limit(1)->get();
        // dd(($classifieds));
        // $apiKey = env('API_KEY_TWO');
        $apiKey = env('API_KEY');

        $client = new \GuzzleHttp\Client();
        $dev_url = "http://127.0.0.1:8000/";
        $prod_url = "https://immobiliere.tn/";
        // $client = new \GuzzleHttp\Client();
        foreach ($classifieds as $classified) {
            $user = $classified->user;
            $email = urldecode($user->email);

            try {
                // check user

                $response = $client->request('GET', $prod_url . 'api/users/classified/check', [
                    'headers' => [
                        'X-API-KEY' => $apiKey,
                    ],
                    'query' => [
                        'email' => $email,
                    ],
                    'verify' => false, // Disable SSL verification
                ]);

                $statusCode = $response->getStatusCode();

                $responseBody = $response->getBody()->getContents();

                $dataCheckUser = json_decode($responseBody, true);
                // dd($statusCode);
                // dd($dataCheckUser);

                if ($statusCode == 200) {
// die('eee');
                    if ($dataCheckUser['exists'] == false) {

                        $userResponse = $client->request('POST', $prod_url . 'api/register/classified', [
                            'headers' => [
                                'X-API-KEY' => $apiKey, // Add your API key
                            ],
                            'form_params' => [
                                'full_name' => $user->full_name,
                                'email' => $user->email,
                                'password' => $user->password, // Ensure the password is hashed before sending
                            ],
                            'verify' => false, // Disable SSL verification if needed
                        ]);
                        $statusCodeRegister = $userResponse->getStatusCode();
                        // dd($userResponse);

                        $responseRegisterBody = $userResponse->getBody()->getContents();
                        $dataRegisterUser = json_decode($responseRegisterBody, true);

                        // if($dataRegisterUser['status'])
                        $user_id = $dataRegisterUser['index'];
                        // dd($dataRegisterUser['index']);
                    } else {
                        if ($dataCheckUser['exists'] == true) {

                            $user_id = $dataCheckUser['index'];
                        } else {
                            Log::info('Response user id problem: ' . $dataCheckUser);
                            dd($dataCheckUser);
                        }
                    }

                    $classifiedData = [
                        [
                            'name'     => 'title',
                            'contents' => $classified->title,
                        ],
                        [
                            'name'     => 'description',
                            'contents' => $classified->description,
                        ],
                        [
                            'name'     => 'price',
                            'contents' => $classified->price,
                        ],
                        [
                            'name'     => 'category_id',
                            'contents' => $classified->category_id,
                        ],
                        [
                            'name'     => 'advertis_type',
                            'contents' => $classified->advertis_type,
                        ],
                        [
                            'name'     => 'product_type',
                            'contents' => $classified->product_type,
                        ],
                        [
                            'name'     => 'product_condition',
                            'contents' => $classified->product_condition,
                        ],
                        [
                            'name'     => 'user_id',
                            'contents' => $user_id,
                        ],
                        [
                            'name'     => 'slug',
                            'contents' => $classified->slug,
                        ],
                        [
                            'name'     => 'city_id',
                            'contents' => $classified->city_id,
                        ],
                        [
                            'name'     => 'area_id',
                            'contents' => $classified->area_id,
                        ],
                        [
                            'name'     => 'status',
                            'contents' => $classified->status,
                        ],
                        // Add other classified fields here
                    ];

                    // Handle the main picture
                    if ($classified->mainPicture) {
                        $mainPicturePath = public_path('uploads/classified/main_picture/' . $classified->mainPicture->picture_path);
                        if (file_exists($mainPicturePath)) {
                            $classifiedData[] = [
                                'name'     => 'main_picture',
                                'contents' => Utils::tryFopen($mainPicturePath, 'r'),
                                'filename' => basename($mainPicturePath),
                            ];
                        }
                    }

                    // Handle multiple images
                    if ($classified->pictures) {
                        foreach ($classified->pictures as $index => $picture) {
                            $imagePath = public_path('uploads/classified/multi_images/' . $picture->picture_path);
                            if (file_exists($imagePath)) {
                                $classifiedData[] = [
                                    'name'     => "images[$index]",
                                    'contents' => Utils::tryFopen($imagePath, 'r'),
                                    'filename' => basename($imagePath),
                                ];
                            }
                        }
                    }

                    try {
                        // dd("zz");
                        // Make the POST request using Guzzle with form data and files
                        $classifiedResponse = $client->request('POST', $prod_url .'api/add/classified/', [
                            'headers' => [
                                'X-API-KEY' => $apiKey,
                            ],
                            'multipart' => $classifiedData,  // Guzzle handles file uploads with 'multipart'
                            'verify' => false,  // Disable SSL verification if needed
                        ]);
                        // dd($classifiedResponse);
                    
                        // Get and log the response
                        $responseBodyClassified = $classifiedResponse->getBody()->getContents();
                        // dd($responseBodyClassified);
                        Log::info('Classified response: ' . $responseBodyClassified);
                    } catch (\GuzzleHttp\Exception\RequestException $e) {
                        // Handle request error
                        dd($e->getMessage());
                        Log::error('Error adding classified: ' . $e->getMessage());
                    }

                    
                }
                
                Log::info('Response from API for email ' . $email . ': ' . $responseBody);

                

                // Process $data as needed
            } catch (\GuzzleHttp\Exception\RequestException $e) {
                // Handle request error and log it

                dd($e->getMessage());

                Log::error('Error fetching API for email ' . $email . ': ' . $e->getMessage());
            }
        }
    }
}
