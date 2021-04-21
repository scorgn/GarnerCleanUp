<?php

return [
    'base_uri'=> 'https://www.eventbriteapi.com/v3/',
    'auth_url' => 'https://www.eventbrite.com/oauth/authorize?response_type=code&client_id=%s',
    'api_key' => env('EVENTBRITE_API_KEY'),
    'client_secret' => env('EVENTBRITE_CLIENT_SECRET'),
    'private_token' => env('EVENTBRITE_PRIVATE_TOKEN'),
    'public_token' => env('EVENTBRITE_PUBLIC_TOKEN'),
    'organizer_id' => env('ORGANIZER_ID'),
    'organization_id' => env('ORGANIZATION_ID'),
];
//private string $baseUrl,
//private string $authUrl,
//private string $clientKey,
//private string $apiKey,
//private string $clientSecret,
//private string $privateToken,
//private string $publicToken,
//private string $organizerId,
