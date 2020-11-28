<?php

// Routes
use Slim\Http\Request;
use Slim\Http\Response;

$app->group('/api', function () use ($app) {
    $app->group('/v1', function () use ($app) {
        /**
         * Route GET /api/v1/albums
         */
        $app->get('/albums', 'AlbumController:findAlbums');
        /**
         * Route GET /api/v1/artists
         */
        $app->get('/artists', 'ArtistController:findArtists');
    });
});