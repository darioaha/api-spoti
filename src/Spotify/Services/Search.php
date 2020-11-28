<?php


namespace App\Spotify\Services;


use App\Exception\SpotifyApiException;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\RequestException;

class Search extends Service
{

    /**
     * Search for an Artist to get id (Access Token required)
     *
     * @param string $accessToken - Access Token
     * @param string $q - Search query (artist name)
     *
     * @return string
     * @throws \Exception
     */
    public function searchArtist($q, $page=0)
    {
        $q = preg_replace('/\s+/', '%20', $q);
        $offset = intval($page)*intval($this->limit);
        $endpoint = "v1/search?type=artist&limit=".$this->limit."&offset=".$offset."&q=".$q;
        try {
            $client = new Client(
                [
                    'base_uri' => self::API,
                    'headers' => $this->headers
                ]
            );

            $result = $client->get($endpoint);
            $return_data = $this->processResult($result);
            return $return_data;
        } catch (ClientException $e) {
            switch ($e->getCode()) {
                case 401:
                    throw new SpotifyApiException('Not authorized to search: ' . $e->getMessage());
                case 404:
                    throw new SpotifyApiException('Resource search not found: ' . $e->getMessage());
                default:
                    throw new SpotifyApiException('Client Error search: ' . $e->getMessage() . " - code: " . $e->getCode());
            }
        } catch (RequestException $e) {
            throw new SpotifyApiException('Malformed request in search: ' . $e->getMessage());
        } catch (Exception $e) {
            throw new SpotifyApiException('Unexpected error in search service: ' . $e->getMessage());
        }
    }
}