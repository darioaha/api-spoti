<?php


namespace App\Exception;

class SpotifyApiException extends \Exception
{
    protected $statusCode;

    public function __construct($message)
    {
        parent::__construct($message);
    }
}
