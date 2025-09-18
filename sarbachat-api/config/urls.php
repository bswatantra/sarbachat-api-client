<?php

declare(strict_types=1);

return [
    /*
     * |--------------------------------------------------------------------------
     * | API and Frontend URLs
     * |--------------------------------------------------------------------------
     * |
     * | Configuration for external service URLs, including Facebook API endpoints
     * | and frontend base URL. Values can be overridden via environment variables.
     * |
     */
    'facebook' => [
        'base_url' => env('FACEBOOK_API_BASE_URL', 'https://graph.facebook.com'),
        'version' => env('FACEBOOK_API_VERSION', 'v22.0'),
        'base_path' => env('FACEBOOK_API_BASE_URL', 'https://graph.facebook.com').'/'.env('FACEBOOK_API_VERSION', 'v22.0'),
    ],
    'frontend' => [
        'base_url' => env('CLIENT_BASE_URL', ''),
        'success' => config('frontend.base_url').'/social-media-manager',
        'failure' => config('frontend.base_url').'/social-media-manager',
    ],
];
