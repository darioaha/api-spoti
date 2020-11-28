<?php


namespace App\Exception;


class ArtistIDNotFoundException extends \Exception
{
    protected $statusCode;

    public function __construct($message)
    {
        parent::__construct($message);
    }
}