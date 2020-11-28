<?php

namespace App\Controllers;


use App\Exception\EmptyCollectionArtistException;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Monolog\Logger;
use App\Spotify\SpotifyServicesFacade;
use Psr\Log\LoggerInterface;
use App\Exception\ArtistCollectionDTOParseException;
use App\Exception\SpotifyApiException;

/**
 * Class ArtistController.
 */
class ArtistController extends Controller
{
    /**
     * @param \Psr\Http\Message\ServerRequestInterface $request
     * @param \Psr\Http\Message\ResponseInterface $response
     * @param array $args
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function findArtists(Request $request, Response $response, $args)
    {
        try{
            $params = $request->getQueryParams();
            $q = $params['q'];
            $page = !empty($params['page']) ? $params['page'] : 0;
            $this->logger->info($request->getUri().". qa=".$q);

            $artists = $this->artistsvc->getArtists($q,$page);

            return $response->withJson($artists,200);
        } catch (\Exception $e) {
            $this->logger->error(
                "Error processing findAlbums: ".$e->getMessage(), [
                    'params' => $request->getQueryParams(),
                    'classException' => get_class($e)
                ]
            );
            if ($e instanceof ArtistCollectionDTOParseException) {
                $code = 40;
                $error = "Error parsing Album Collection";
            } elseif ($e instanceof SpotifyApiException) {
                $code = 400;
                $error = "Error Request Api Spotify";
            } elseif ($e instanceof EmptyCollectionArtistException) {
                $code = 400;
                $error = "Artists Not Found with query";
            } else {
                $code = 500;
                $error = "Unexpected error findAlbums";
            }
            return $response->withJson([
                'message' => $error
            ], $code);
        }
    }

}