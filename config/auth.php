<?php

return [


    'defaults' => [
        'guard' => 'web',
        'passwords' => 'users',
    ],


    'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'users',
        ],

        'service_user' => [
            'driver' => 'session',
            'provider' => 'service_users',
        ],
    
        'classified_user' => [
            'driver' => 'session',
            'provider' => 'classified_users',
        ],
    ],

    

    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model' => App\Models\User::class,
        ],
        'service_users' => [
            'driver' => 'eloquent',
            'model' => App\Models\ServiceUser::class,
        ],
    
        'classified_users' => [
            'driver' => 'eloquent',
            'model' => App\Models\ClassifiedUser::class,
        ],
        // 'users' => [
        //     'driver' => 'database',
        //     'table' => 'users',
        // ],
    ],

    

    'passwords' => [
        'users' => [
            'provider' => 'users',
            'table' => 'password_reset_tokens',
            'expire' => 60,
            'throttle' => 60,
        ],

        'service_users' => [
            'provider' => 'service_users',
            'table' => 'password_resets',
            'expire' => 60,
        ],
    
        'classified_users' => [
            'provider' => 'classified_users',
            'table' => 'password_resets',
            'expire' => 60,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Password Confirmation Timeout
    |--------------------------------------------------------------------------
    |
    | Here you may define the amount of seconds before a password confirmation
    | times out and the user is prompted to re-enter their password via the
    | confirmation screen. By default, the timeout lasts for three hours.
    |
    */

    'password_timeout' => 10800,

];
