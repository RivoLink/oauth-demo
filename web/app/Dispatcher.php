<?php

namespace App;

use App\Controllers\MainController;
use App\Controllers\SigninController;
use App\Controllers\SignupController;

class Dispatcher {

    private static $main;
    private static $signin;
    private static $signup;
   
    public static function get($class){
        switch($class){
            case MainController::class: {
                if(!self::$main){
                    self::$main = new MainController();
                }
                return self::$main;
            }
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
