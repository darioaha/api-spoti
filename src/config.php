<?php

/**
 * load .env
 */
if (file_exists(__DIR__ . '../.env')) {
    $dotenv = new Dotenv\Dotenv(__DIR__);
    $dotenv->load();
    $dotenv->required([
        'ENVIRONMENT',
        'LOG_LEVEL',
        'API_URL_SPOTIFY',
        'API_CLIENT_SPOTIFY',
        'API_SECRET_SPOTIFY',
        'API_QUERY_LIMIT_SPOTIFY',
    ]);
} else {

}
