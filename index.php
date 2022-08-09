<?php

require 'vendor/autoload.php';

use App\Router;
use App\SQLite;

$sqlite = null;

try {
    $sqlite = new SQLite();
    $sqlite->connect();
    $sqlite->createTableUser();
} 
catch(Exception $e){
    http_response_code(505);
    echo "Could not connect to the SQLite database : ".$e->getMessage();
    die();
}

Router::handle();
