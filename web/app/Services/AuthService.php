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

}
