<?php

// DIC configuration
use Monolog\Logger;

$container = $app->getContainer();

/**
 * @return Monolog\Logger
 */
$container['logger'] = function ($c) {
    $settings = $c->get('settings')['logger'];
    $logger = new Monolog\Logger($settings['name']);
    $logger->pushProcessor(new Monolog\Processor\UidProcessor());
    $logger->pushHandler(new Monolog\Handler\StreamHandler($settings['path'], $settings['level']));
    return $logger;
};

/**
 * @return Monolog\Logger
 */
$container['log-spotify'] = function ($c) {
    $settings = $c->get('settings')['logger'];
    $logger = new Monolog\Logger("svc-spotify");
    $logger->pushProcessor(new Monolog\Processor\UidProcessor());
    $logger->pushHandler(new Monolog\Handler\StreamHandler($settings['path'], $settings['level']));
    return $logger;
};

/**
 * @return App\Spotify\SpotifyServicesFacade
 */
$container['spotify'] = function ($c) {
    return new App\Spotify\SpotifyServicesFacade(
        $c['log-spotify'],
        $settings = $c->get('settings')['api-spotify']
    );
};

/**
 * @return App\Services\AlbumServices
 */
$container['albumsvc'] = function ($c) {
    return new App\Services\AlbumServices(
        $c['logger'],
        $settings = $c['spotify']
    );
};

/**
 * @return App\Services\ArtistServices
 */
$container['artistsvc'] = function ($c) {
    return new App\Services\ArtistServices(
        $c['logger'],
        $settings = $c['spotify']
    );
};

$container['AlbumController'] = function($c) {
    return new \App\Controllers\AlbumController($c);
};

$container['ArtistController'] = function($c) {
    return new \App\Controllers\ArtistController($c);
};