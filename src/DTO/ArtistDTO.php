<?php

namespace App\DTO;

use App\Exception\ArtistIDNotFoundException;

class ArtistDTO
{
    /**
     * Get the first match from the list of artists (most popular artist)
     *
     * @param $responseArtist
     * @return string
     * @throws AlbumCollectionDTOParseException
     */
    public static function getFirstArtistIDFromResponse($responseArtist)
    {
        try{
            return $responseArtist['artists']['items'][0]['id'];
        } catch(\Exception $e) {
            throw new ArtistIDNotFoundException("Error getting artist ID");
        }
    }

    public static function fromResponse($itemArtist)
    {
        return [
            'name' => $itemArtist["name"]
        ];
    }

}