<?php

namespace App;

use App\Services\AuthService;
use App\Controllers\SignupController;

class Router {

    private static function check($uri, $strict=true){
        if($strict){
            return $_SERVER['REQUEST_URI'] === $uri;
        }
        return (strpos($_SERVER['REQUEST_URI'], $uri) === 0);
    }
   
    public static function handle(){
        $URI = $_SERVER['REQUEST_URI'];

        $signup = Dispatcher::get(SignupController::class);

        $auth = (
            AuthService::isAuth() &&
            !self::check('/logout') &&
            !self::check('/dashboard')
        );

        if($auth){
            $signup->redirect("/dashboard");
        }
        else if(!$URI || ($URI === '/')){
            require 'views/sign-in.php';
        }
        else if(self::check('/sign-in')){
            require 'views/sign-in.php';
        }
        else if(self::check('/sign-up')){
            require 'views/sign-up.php';
        }
        else if(self::check('/logout')){
            require 'views/logout.php';
        }
        else if(self::check('/dashboard')){
            require 'views/dashboard.php';
        }
        else if(self::check('/api/sign-up/google-url')){
            $signup->googleUrl($_POST, $_GET);
        }
        else if(self::check('/api/sign-up/google-callback', false)){
            $signup->googleCallback($_POST, $_GET);
        }
        else {
            http_response_code(404);
            require 'views/404.php';
        }
    }
}
