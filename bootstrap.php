<?php

/* 
 * This file is the 'preloader' that is responsible for setting everything up. 
 * Think of this as an initialization script.
 * This should be included for the web interface AND any scripts/processes that run separately, thus
 * it should only contain logic that any processes/services will need.
 */

require_once(__DIR__ . '/vendor/autoload.php'); # this autoloads all vendor packages

// Define which folders contain all of our php classes.
$classDirs = array(
    __DIR__ . '/src/Controllers',
    __DIR__ . '/src/DTO',
    __DIR__ . '/src/Exception',
    __DIR__ . '/src/Spotify',
    __DIR__ . '/src/Services',
);

$autoloader = new iRAP\Autoloader\Autoloader($classDirs);

# put your custom init stuff here....
