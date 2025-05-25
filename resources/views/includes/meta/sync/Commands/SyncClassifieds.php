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
        $classifieds = Classified::where('synced', true)->where('status', 1)->orderBy("created_at","asc")->limit(1)->get();
        // dd((count($classifieds)));
        $apiKey = env('API_KEY_TWO');
        

        $client = new \GuzzleHttp\Client();
        $dev_url = "http://127.0.0.1:8000/";
        $prod_url = "https://les-annonces.com.tn/";
Log::info('url for check email classified ' . $prod_url );
        if (count($classifieds) > 0) {
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
                    // dd($dataCheckUser);
                    Log::info('Response from API for check email ' . $email . ': ' . $responseBody);


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
                                    'phone' => $user->phone,
                                    
                                    'city_id' => $user->city_id,
                                    'country_id' => $user->country_id,
                                    
                                    'address' => $user->address,
                                    'password' => $user->password,
                                ],
                                'verify' => false, // Disable SSL verification if needed
                            ]);
                            $statusCodeRegister = $userResponse->getStatusCode();
                            // dd($userResponse);

                            $responseRegisterBody = $userResponse->getBody()->getContents();
                            $dataRegisterUser = json_decode($responseRegisterBody, true);
                            // dd($dataRegisterUser);
                            Log::info('Response from API create classified '  . $responseRegisterBody);

                            // if($dataRegisterUser['status'])
                            $user_id = $dataRegisterUser['index'];
                            // dd($dataRegisterUser['index']);
                        } else {
                            if ($dataCheckUser['exists'] == true) {

                                $user_id = $dataCheckUser['index'];
                            } else {
                                Log::info('Response user id problem: ' . $dataCheckUser);
                                
                            }
                        }
                        // dd($user_id);
                        if ($user_id !== "") {
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
                                // [
                                //     'name'     => 'slug',
                                //     'contents' => $classified->slug,
                                // ],
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
                            if (count($classified->pictures) >= 0) {
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




                            // dd("zz");
                            // Make the POST request using Guzzle with form data and files
                            $classifiedResponse = $client->request('POST', $prod_url . 'api/add/classified', [
                                'headers' => [
                                    'X-API-KEY' => $apiKey,
                                ],
                                'multipart' => $classifiedData,
                                // Guzzle handles file uploads with 'multipart'
                                'verify' => false,  // Disable SSL verification if needed
                            ]);

                            $statusCode = $classifiedResponse->getStatusCode();  // Expect 200 for success
                            $responseBodyClassified = $classifiedResponse->getBody()->getContents();
                            $dataAddClassified = json_decode($responseBodyClassified, true); // Should be "good"
                            //dd($dataAddClassified);
                            // Log the status code and response body
                            Log::info('Status Code: ' . $statusCode);
                            

                            if ($dataAddClassified['success']) {
                                // Success is true
                                // Do something here
                                // dd($statusCode);
                                $classified->update(['synced' => false]);
                            }
                            // Print the status code and response body for debugging

                            // Log::info('Response from API for cretae classified json:' . $responseBodyClassified);
                        } else {
                            Log::info('Error for create classified raison user id empty:' . $user_id);
                        }




                        // Get and log the response
                        // echo $responseBodyClassified;
                        // dd();

                    }




                    // Process $data as needed
                } catch (\GuzzleHttp\Exception\RequestException $e) {
                    // Handle request error and log it

                    // dd($e->getMessage());

                    Log::error('Error for All API Classified '  . $e->getMessage());
                }
            }
        }else{
            Log::info('No Item for sync classified ');
        }
        
    }
}
