<?php


namespace App\Exception;


class EmptyAlbumsArtistException extends \Exception
{
    protected $statusCode;

    public function __construct($message)
    {
        parent::__construct($message);
    }
}