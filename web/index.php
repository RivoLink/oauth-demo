<?php
session_start();

require 'core.php';
require '../vendor/autoload.php';

use App\Config;
use App\Router;
use App\SQLite;

try {
    SQLite::connect();
    SQLite::createTable();
} 
catch(Exception $e){
    http_response_code(505);
    echo "Could not connect to the SQLite database : ".$e->getMessage();
    die();
}

Config::check();
Router::handle();
