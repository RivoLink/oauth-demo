<?php

namespace App\Controllers;

abstract class Controller {

    public function redirect($uri="", $errors=null){
        $this->addErrors($errors);
        header('Location: '.base_url($uri));
        exit;
    }

    public function view($path, $params=[]){
        if(is_array($params)) foreach($params as $key=>$value){
            global ${$key};
            ${$key} = $value;
        }
        require $path;
    }

    protected function dump($value){
        var_dump($value);
    }

    protected function json($array){
        header("Content-Type: application/json");
        echo json_encode($array);
        exit();
    }

    protected function throwAccessDenied(){
        http_response_code(403);
        require("views/403.php");
    }

    protected function getErrors(){
        $errors = [];
        if(is_array($_SESSION) && isset($_SESSION["ERRORS"])){
            $errors = $_SESSION["ERRORS"];
            $_SESSION["ERRORS"] = [];
        }
        return $errors;
    }

    protected function addErrors($errors){
        if(is_array($_SESSION) && is_array($errors)){
            if(!isset($_SESSION["ERRORS"])){
                $_SESSION["ERRORS"] = [];
            }

            $_SESSION["ERRORS"] = array_merge(
                $_SESSION["ERRORS"],
                $errors
            );
        }
    }

}
