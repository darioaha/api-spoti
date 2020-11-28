<?php


namespace App\Helpers;

use App\Exception\MetadataParseException;

class AlbumResponseMetadata
{
    public static function fromResponse($responseAlbums)
    {
        try{
            return [
                "total" => $responseAlbums['total'],
                "limit" => $responseAlbums['limit'],
                "offset" => $responseAlbums['offset'],
                "total_pages" => floor(intval($responseAlbums['total'])/intval($responseAlbums['limit']))
            ];
        } catch(\Exception $e) {
            throw new MetadataParseException("Error parsing metadata albums");
        }
    }
}