<?php

namespace App\Spotify\Services;

use App\Exception\SpotifyApiException;

abstract class Service
{
    const API = 'https://api.spotify.com/';
    protected $accessToken;
    protected $headers;
    protected $limit;

    public function __construct($limit)
    {
        $this->accessToken = null;
        $this->headers = null;
        $this->limit = $limit;
    }

    /**
     * @param string $acccessToken
     */
    public function setAccessToken($accessToken)
    {
        $this->accessToken = $accessToken;
        $this->headers = ['Authorization' => 'Bearer ' . $this->accessToken];
//        $this->headers = array_merge($this->headers, [
//            'Authorization' => 'Bearer ' . $accessToken,
//        ]);
    }

    protected function processResult($result)
    {
        if ($result->getBody()) {
            $json_result = $result->getBody();
            $return = @\GuzzleHttp\json_decode($json_result, true);
            if ($return === null
                && json_last_error() !== JSON_ERROR_NONE
            ) {
                throw new SpotifyApiException("Error converting server response to JSON");
            } else {
                return $return;
            }
        } else {
            throw new SpotifyApiException("Unexpected error: get body from response");
        }
    }

}


