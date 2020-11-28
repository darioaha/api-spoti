<?php

namespace App\Services;

use App\DTO\AlbumCollectionDTO;
use App\DTO\ArtistCollectionDTO;
use App\DTO\ArtistDTO;
use App\Spotify\Services\Albums;
use App\Spotify\Services\Auth;
use App\Spotify\Services\Search;
use App\Spotify\SpotifyServicesFacade;
use Monolog\Logger;
use App\Exception\EmptyCollectionArtistException;

class ArtistServices
{
    /**
     * @var Logger
     */
    protected $logger;
    /**
     * @var SpotifyServicesFacade
     */
    protected $spotifyServices;

    public function __construct(Logger $logger, SpotifyServicesFacade $spotifyServices)
    {
        $this->logger = $logger;
        $this->spotifyServices = $spotifyServices;
    }

    public function getArtists($q,$page=0)
    {
        $this->spotifyServices->AccessToken();
        $artistsResponse = $this->spotifyServices->searchArtist($q,$page);
        $artists = ArtistCollectionDTO::fromResponse($artistsResponse);
        if (!empty($artists)){
            return $artists;
        }
        $this->logger->warning("Not artists found with q:".$q." and page:".$page);
        throw new EmptyCollectionArtistException("Not artists found with q:".$q." and page:".$page);
    }
}