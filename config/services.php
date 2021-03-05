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
        'domain' => env('MAILGUN_DOMAIN', 'https://bauxanh.todo.vn/'),
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
        'client_id' => '211494700237869',
        'client_secret' => 'f5dd9d1c09ad6219e4f6286524436856',
        'redirect' => 'https://dev.pavis.com/auth/facebook/callback',
//        'redirect' => env('auth/facebook/callback'),
    ],

    'google' => [
        'client_id' => '1019495030338-6nn8b7vphfobul8emisir8coo1oa7vaf.apps.googleusercontent.com',
        'client_secret' => 'nikW2hY02vJ1wx0QVqCriXU_',
        'redirect' => 'https://dev.pavis.com/auth/google/callback',
    ],
];
