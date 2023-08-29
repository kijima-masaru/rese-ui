<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'stripe' => [
        'key' => env('pk_test_51NjMYZHuosYE03blXTaFQPxuno5yZsJcyjw9F4x8jXwK7SgnWJHOD52SGcoRnLG8CJQPsPkchciE4EI5EjliMojw00o8XjGnDm'),
        'secret' => env('sk_test_51NjMYZHuosYE03bl4HVIfgB3xpYUhte3Oe1gjMAj4Al7qFFohmIIWvIdNj5kSP8AR5M96L5njVGjNO8YIxg3mmoO00kgEWRpDz'),
    ],


];
