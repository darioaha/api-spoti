<?php


namespace App\Spotify\Services;


use App\Exception\SpotifyApiException;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\RequestException;

class Albums extends Service
{

    /**
     * Search albums from Artist (Access Token required)
     *
     * @param string $artistID - Search query (artist ID)
     *
     * @return array
     * @throws \Exception
     */
    public function getAlbums($artistID,$page=0)
    {
        $offset = intval($page)*intval($this->limit);

        $endpoint = "v1/artists/".$artistID."/albums?limit=".$this->limit."&offset=".$offset;
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