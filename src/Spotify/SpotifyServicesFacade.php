<?php

namespace App\Spotify;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\ClientException;
use Monolog\Logger;
use App\Exception\SpotifyApiException;
use App\Spotify\Services\Auth;
use App\Spotify\Services\Search;
use App\Spotify\Services\Albums;

class SpotifyServicesFacade
{
    /**
     * @var Logger
     */
    protected $logger;
    /**
     * @var string
     */
    protected $baseURI;
    /**
     * @var string
     */
    protected $clientID;
    /**
     * @var string
     */
    protected $clientSecret;
    /**
     * @var string
     */
    protected $limit;
    /**
     * @var string
     */
    protected $accessToken;

    public function __construct(Logger $logger, $spotifySettings)
    {
        $this->logger = $logger;
        $this->baseURI = "https://api.spotify.com/";
        $this->clientID = $spotifySettings['username'];
        $this->clientSecret = $spotifySettings['password'];
        $this->limit = $spotifySettings['limit'];
    }

    public function AccessToken()
    {
        $accessToken = new Auth();
        $this->accessToken = $accessToken->getAccessToken($this->clientID,$this->clientSecret);
    }

    public function searchArtist($q, $page=0)
    {
        $search = new Search($this->limit);
        $search->setAccessToken($this->accessToken);
        return $search->searchArtist($q, $page);
    }

    public function getAlbums($artistID,$page=0)
    {
        $albumsSVC = new Albums($this->limit);
        $albumsSVC->setAccessToken($this->accessToken);
        $albums = $albumsSVC->getAlbums($artistID,$page);
        return $albums;
    }

}
