<?php

function config($name){
    return constant("App\Config::$name");
}

function is_auth(){
    if(isset($_SESSION["AUTH_ID"])){
        return $_SESSION["AUTH_ID"];
    }
    return null;
}

function base_url($uri=""){
    return (
        (isset($_SERVER['HTTPS']) ? "https" : "http") . //scheme
        ("://$_SERVER[HTTP_HOST]") . //host:port
        ($uri ? $uri : "") //uri
    );
}

function dump($var){
    if(is_array($var)){
        $var = json_encode(
            $var, 
            JSON_PRETTY_PRINT
        );
    }
    else if(is_object($var)){
        $var = json_encode(
            (array)$var, 
            JSON_PRETTY_PRINT
        );
    }
    echo $var;
}

function get($array, $key, $default=null){
    if(is_array($array) && $key){
        if(strpos($key, '|') > 0){
            list($field, $prop) = explode('|', $key);
            
            if(isset($array[$field][$prop])){
                return $array[$field][$prop];
            }
        }
        else if(isset($array[$key])){
            return $array[$key];
        }
    }
    return $default;
}

function gen_pwd($length=12){
    $chars = "0123456789abcdefghijklmnopqrstuvwxyz!@#$%^&*()ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    $chars_lenth = strlen($chars);
    $password = "";

    for($i=0; $i<$length; $i++){
        $math_random = (float)rand()/(float)getrandmax();
        $randomNumber = (int)floor($math_random * $chars_lenth);
        $letter = substr($chars, $randomNumber, 1);
        $password .= $letter;
    }

    $rand_byte = bin2hex(random_bytes(5));
    $password = $rand_byte.$password;
    return $password;
}
