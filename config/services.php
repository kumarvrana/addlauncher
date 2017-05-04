<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, SparkPost and others. This file provides a sane
    | default location for this type of information, allowing packages
    | to have a conventional place to find your various credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
    ],

    'ses' => [
        'key' => env('SES_KEY'),
        'secret' => env('SES_SECRET'),
        'region' => 'us-east-1',
    ],

    'sparkpost' => [
        'secret' => env('SPARKPOST_SECRET'),
    ],

    'stripe' => [
        'model' => App\User::class,
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
    ],

    'facebook' => [
        'client_id' => '116656438888435',
        'client_secret' => 'd7232f5f9d13d24b020e525ff4ca3d09',
        'redirect' => 'http://myshop.dev/myshop/public/',
    ],

    'github' => [
        'client_id' => '218052c217db39e57e71',
        'client_secret' => 'ce5b1efd95d26a46d5c00e4a5128616b12d82ad0',
        'redirect' => 'http://192.168.0.39/myshop/public/login/facebook',
    ],
    'google' => [
        'client_id' => '272677893372-9gil6orv58tefk88kfgj9btski5s696e.apps.googleusercontent.com',
        'client_secret' => 'TVk2kMZoj_GB7wZlsOSx3uun',
        'redirect' => 'http://myshop.dev/myshop/public/login/google',
    ],

    'linkedin' => [
        'client_id' => '814zbnz1r6ao9f',
        'client_secret' => 'xXpPvFBG1Y9WE359',
        'redirect' => 'http://myshop.dev/myshop/public/login/linkedin/callback',
    ],
    
    'twitter' => [
        'client_id' => 'mDQ52AodwlzVFrQkVKzUpQkqm',
        'client_secret' => 'jRwd5XmKlIyOT4hE9fnD90T7ihh6JaBYPT0ku9Id0PQBgSbzeh',
        'redirect' => 'http://myshop.dev/myshop/public/login/twitter/callback',
    ],
    
];
