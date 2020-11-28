<?php

namespace App\DTO;

use App\Exception\ArtistCollectionDTOParseException;


class ArtistCollectionDTO
{
    public static function fromResponse($artistsResponse)
    {
        try{
            $artists = array_map(function($artist) {
                return ArtistDTO::fromResponse($artist);
            }, $artistsResponse['artists']['items']);
            return $artists;
        } catch(\Exception $e) {
            throw new ArtistCollectionDTOParseException("Error parsing artists");
        }
    }
}