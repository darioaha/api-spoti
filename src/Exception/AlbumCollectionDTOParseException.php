<?php


namespace App\Exception;


class AlbumCollectionDTOParseException extends \Exception
{
    protected $statusCode;

    public function __construct($message)
    {
        parent::__construct($message);
    }
}
