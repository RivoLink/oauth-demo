<?php

namespace App\Services;

class AuthService {

    public static function isAuth(){
        if(isset($_SESSION["AUTH_ID"])){
            return $_SESSION["AUTH_ID"];
        }
        return null;
    }

    public static function setAuth($user){
        if($user && isset($user["id"])){
            $_SESSION["AUTH_ID"] = $user["id"];
            return true;
        }
        return false;
    }

    public static function getCSRF($gen=false){
        if(!$_SESSION || !isset($_SESSION["AUTH_ID"])){
            return uniqid();
        }

        if($gen || !$_SESSION["AUTH_ID"]){
            $_SESSION["AUTH_ID"] = uniqid();
        }

        return $_SESSION["AUTH_ID"];
    }

}
