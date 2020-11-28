<?php

namespace App\Services;

use App\DTO\AlbumCollectionDTO;
use App\DTO\ArtistDTO;
use App\Helpers\AlbumResponseMetadata;
use App\Spotify\Services\Albums;
use App\Spotify\Services\Auth;
use App\Spotify\Services\Search;
use App\Spotify\SpotifyServicesFacade;
use Monolog\Logger;
use App\Exception\EmptyAlbumsArtistException;

class AlbumServices
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

    public function getAlbums($q,$page=0)
    {
        $this->spotifyServices->AccessToken();
        $artistsResponse = $this->spotifyServices->searchArtist($q);
        $artistID = ArtistDTO::getFirstArtistIDFromResponse($artistsResponse);
        $this->logger->debug("Artist ID: ".$artistID);
        $albums = $this->spotifyServices->getAlbums($artistID,$page);
        if (!empty($albums['items'])){
            $albumsDTO = AlbumCollectionDTO::fromResponse($albums);
            $metadataPagination = AlbumResponseMetadata::fromResponse($albums);
            $metadataPagination['page'] = $page;
            return [$metadataPagination,$albumsDTO];
        }
        $this->logger->warning("Empty albums from artistID:".$artistID);
        throw new EmptyAlbumsArtistException("Empty albums from artist ".$q);
    }
}