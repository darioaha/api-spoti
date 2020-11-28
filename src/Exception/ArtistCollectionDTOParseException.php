<?php


namespace App\Exception;


class ArtistCollectionDTOParseException extends \Exception
{
    protected $statusCode;

    public function __construct($message)
    {
        parent::__construct($message);
    }
}