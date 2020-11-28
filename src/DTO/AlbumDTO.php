<?php


namespace App\DTO;


class AlbumDTO
{
    public static function fromResponse($itemAlbum)
    {
        return [
            'name' => $itemAlbum["name"],
            'tracks' => $itemAlbum["total_tracks"],
            'released' => $itemAlbum["release_date"],
            'cover' => $itemAlbum["images"][0],
        ];
    }
}