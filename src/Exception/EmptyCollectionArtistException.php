<?php


namespace App\Exception;


class EmptyCollectionArtistException extends \Exception
{
    protected $statusCode;

    public function __construct($message)
    {
        parent::__construct($message);
    }
}