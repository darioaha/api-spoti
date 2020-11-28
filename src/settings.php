<?php

return [
    'settings' => [
        'displayErrorDetails'    => true, //Use envvar for production
        'addContentLengthHeader' => false,
        'logger' => [
            'name'  => 'Api',
            'path'  => !empty(getenv('DOCKER')) ? 'php://stdout' : (__DIR__ . '/../logs/app.log'),
            'level' => \Monolog\Logger::DEBUG,
        ],
        // Spotify Api
        'api-spotify' => [
            'host' => getenv('API_HOST_SPOTIFY'),
            'username' => getenv('API_CLIENT_SPOTIFY'),
            'password' => getenv('API_SECRET_SPOTIFY'),
            'limit' => getenv('API_QUERY_LIMIT_SPOTIFY'),
        ],
    ],
];