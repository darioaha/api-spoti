<?php

namespace App\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Monolog\Logger;
use App\Spotify\SpotifyServicesFacade;
use Psr\Log\LoggerInterface;
use App\Exception\AlbumCollectionDTOParseException;
use App\Exception\ArtistIDNotFoundException;
use App\Exception\SpotifyApiException;
use App\Exception\EmptyAlbumsArtistException;


/**
 * Class AlbumController.
 */
class AlbumController extends Controller
{
    /**
     * @param \Psr\Http\Message\ServerRequestInterface $request
     * @param \Psr\Http\Message\ResponseInterface $response
     * @param array $args
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function findAlbums(Request $request, Response $response, $args)
    {
        try{
            $params = $request->getQueryParams();
            $q = $params['q'];
            $page = !empty($params['page']) ? $params['page'] : 0;
            $this->logger->info($request->getUri().". qa=".$q);
            list($metadataPagination, $albums) = $this->albumsvc->getAlbums($q,$page);
            return $response->withHeader(
                'Content-Type', 'application/json'
            )->withAddedHeader(
                '_metadata_pagination', json_encode($metadataPagination)
            )->withJson($albums);
        } catch (\Exception $e) {
            $this->logger->error(
                "Error processing findAlbums: ".$e->getMessage(), [
                    'params' => $request->getQueryParams(),
                    'classException' => get_class($e)
                ]
            );
            if ($e instanceof AlbumCollectionDTOParseException) {
                $code = 40;
                $error = "Error parsing Album Collection";
            } elseif ($e instanceof ArtistIDNotFoundException) {
                $code = 404;
                $error = "Artist ID Not Found";
            } elseif ($e instanceof SpotifyApiException) {
                $code = 400;
                $error = "Error Request Api Spotify";
            } elseif ($e instanceof EmptyAlbumsArtistException) {
                $code = 400;
                $error = "Any albums for the requested Artist";
            } elseif ($e instanceof MetadataParseException) {
                $code = 400;
                $error = "Error parsing pagination metadata";
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