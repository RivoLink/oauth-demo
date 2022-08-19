<?php

namespace App\Controllers;

abstract class Controller {

    public function redirect($uri=""){
        header('Location: '.base_url($uri));
        exit;
    }

    public function dump($value){
        var_dump($value);
    }

    public function json($array){
        header("Content-Type: application/json");
        echo json_encode($array);
        exit();
    }

    public function view($path){
        require $path;
    }

}
