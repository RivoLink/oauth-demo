<?php

namespace App;

use App\Controllers\SigninController;
use App\Controllers\SignupController;

class Dispatcher {

    private static $signin;
    private static $signup;
   
    public static function get($class){
        switch($class){
            case SigninController::class: {
                if(!self::$signin){
                    self::$signin = new SigninController();
                }
                return self::$signin;
            }
            case SignupController::class: {
                if(!self::$signup){
                    self::$signup = new SignupController();
                }
                return self::$signup;
            }
            default: {
                return null;
            }
        }
        return null;
    }

}
