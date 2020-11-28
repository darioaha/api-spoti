<?php

require_once(__DIR__ . '/../bootstrap.php');

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use \Interop\Container\ContainerInterface as ContainerInterface;
use \Monolog\Logger;
use \Psr\Log\LoggerInterface;

require __DIR__.'/../src/config.php';
$settings = require __DIR__.'/../src/settings.php';
$app = new \Slim\App($settings);

require __DIR__.'/../src/dependencies.php';
//require __DIR__.'/../src/middleware.php';
require __DIR__.'/../src/routes.php';

$app->run();






















