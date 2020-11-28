<?php


namespace App\Exception;


class MetadataParseException extends \Exception
{
    protected $statusCode;

    public function __construct($message)
    {
        parent::__construct($message);
    }
}