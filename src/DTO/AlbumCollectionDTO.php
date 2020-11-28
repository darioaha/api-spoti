<?php


namespace App\DTO;

use App\Exception\AlbumCollectionDTOParseException;

class AlbumCollectionDTO
{
    public static function fromResponse($albums)
    {
        try{
            $albums = array_map(function($album) {
                return AlbumDTO::fromResponse($album);
            }, $albums['items']);
            return $albums;
        } catch(\Exception $e) {
            throw new AlbumCollectionDTOParseException("Error parsing albums");
        }
    }
}