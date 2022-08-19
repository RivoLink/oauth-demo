<?php

namespace App;

use App\Controllers\SignupController;

class Dispatcher {

    private static $signup;
   
    public static function get($class){
        switch($class){
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
