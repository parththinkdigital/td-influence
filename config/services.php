<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Resend, Postmark, AWS, and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'postmark' => [
        'key' => env('POSTMARK_API_KEY'),
    ],

    'resend' => [
        'key' => env('RESEND_API_KEY'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

    'google' => [
        'client_id' => env('GOOGLE_CLIENT_ID'),
        'client_secret' => env('GOOGLE_CLIENT_SECRET'),
        'redirect' => env('GOOGLE_REDIRECT_URI', '/auth/google/callback'),
    ],

    'youtube' => [
        'api_key' => env('YOUTUBE_API_KEY'),
    ],

    'meta' => [
        'app_id' => env('INSTAGRAM_APP_ID', env('META_APP_ID')),
        'app_secret' => env('INSTAGRAM_APP_SECRET', env('META_APP_SECRET')),
        'access_token' => env('META_ACCESS_TOKEN'),
        'instagram_account_id' => env('INSTAGRAM_BUSINESS_ACCOUNT_ID'),
        'instagram_redirect_uri' => env('INSTAGRAM_REDIRECT_URI', 'http://localhost:8000/auth/instagram/callback'),
        'webhook_verify_token' => env('INSTAGRAM_WEBHOOK_VERIFY_TOKEN', 'talent_marketplace_secret_2026'),
    ],

    'instagram' => [
        'app_id' => env('INSTAGRAM_APP_ID', env('META_APP_ID')),
        'app_secret' => env('INSTAGRAM_APP_SECRET', env('META_APP_SECRET')),
        'redirect_uri' => env('INSTAGRAM_REDIRECT_URI', 'http://localhost:8000/auth/instagram/callback'),
    ],

    'twitter' => [
        'bearer_token' => env('TWITTER_BEARER_TOKEN'),
        'api_key' => env('TWITTER_API_KEY'),
        'api_secret' => env('TWITTER_API_SECRET'),
    ],

    'tiktok' => [
        'client_key' => env('TIKTOK_CLIENT_KEY'),
        'client_secret' => env('TIKTOK_CLIENT_SECRET'),
        'access_token' => env('TIKTOK_ACCESS_TOKEN'),
    ],

    'whatsapp' => [
        'token' => env('WHATSAPP_TOKEN'),
        'phone_number_id' => env('WHATSAPP_PHONE_NUMBER_ID', '1414905208364680'),
        'api_version' => env('WHATSAPP_API_VERSION', 'v22.0'),
        'template_name' => env('WHATSAPP_TEMPLATE_NAME', 'hello_world'),
        'template_lang' => env('WHATSAPP_TEMPLATE_LANG', 'en_US'),
    ],

];
