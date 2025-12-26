<?php

return [

    'openai' => [
        'key' => env('OPENAI_API_KEY'),
        'organization' => env('OPENAI_ORG_ID'),     // Optional
        'project' => env('OPENAI_PROJECT_ID'),  // Optional
    ],

    'rss2json' => [
        'base_url' => env('RSS2JSON_BASE_URL', 'https://api.rss2json.com/v1/api.json'),
        'api_key' => env('RSS2JSON_API_KEY'),
        'timeout' => 5,       // seconds
        'cache_ttl' => 300,     // seconds
        'cache_enabled' => env('RSS2JSON_CACHE', true),

    ],

];
