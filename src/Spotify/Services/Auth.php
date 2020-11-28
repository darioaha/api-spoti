<?php

namespace App\Spotify\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\ClientException;
use Monolog\Logger;
use App\Exception\SpotifyApiException;

class Auth extends Service
{
    public function __construct()
    {
    }

    /**
     * HTTP POST To request an access token
     *
     * Request to api/token?grant_type=client_credentials
     * https://developer.spotify.com/documentation/general/guides/authorization-guide
     *
     * @return string
     * @throws \Exception
     */
    public function getAccessToken($clientID,$clientSecret)
    {
        $endpoint = 'api/token';
        try {
            $basicB64 = base64_encode($clientID.':'.$clientSecret);
            $headers = [
                'Authorization' => 'Basic ' . $basicB64,
                'Accept' => 'application/json',
            ];
            $client = new Client(
                [
                    'base_uri' => "https://accounts.spotify.com/",
                    'headers' => $headers,
                    'form_params' => [
                        'grant_type' => 'client_credentials'
                    ]
                ]
            );
            $result = $client->post($endpoint);
            $return_data = $this->processResult($result);

            if (!empty($return_data['access_token'])) {
                return $return_data['access_token'];
            } else {
                throw new SpotifyApiException('Error Getting Access Token from response');
            }
        } catch (ClientException $e) {
            switch ($e->getCode()) {
                case 401:
                    throw new SpotifyApiException('Not authorized to get access token: ' . $e->getMessage());
                case 404:
                    throw new SpotifyApiException('Resource token not found: ' . $e->getMessage());
                default:
                    throw new SpotifyApiException('Client Error: ' . $e->getMessage() . " - code: " . $e->getCode());
            }
        } catch (RequestException $e) {
            throw new SpotifyApiException('Malformed request' . $e->getMessage());
        } catch (Exception $e) {
            throw new SpotifyApiException('Unexpected error getting app access token: ' . $e->getMessage());
        }
    }
}