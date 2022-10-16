<?php

namespace App;

use App\Services\AuthService;

use App\Controllers\MainController;
use App\Controllers\SigninController;
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

        $main = Dispatcher::get(MainController::class);
        $signup = Dispatcher::get(SignupController::class);
        $signin = Dispatcher::get(SigninController::class);

        $auth = (
            AuthService::isAuth() &&
            !self::check('/logout') &&
            !self::check('/dashboard')
        );

        if($auth){
            $main->redirect("/dashboard");
        }
        else if(!$URI || ($URI === '/')){
            $main->index();
        }
        else if(self::check('/sign-in')){
            $main->signIn($_POST, $_GET);
        }
        else if(self::check('/sign-up')){
            $main->signUp($_POST, $_GET);
        }
        else if(self::check('/logout')){
            $main->logout();
        }
        else if(self::check('/dashboard')){
            $main->dashboard($_SESSION["AUTH_ID"]);
        }
        else if(self::check('/api/sign-up/google-url')){
            $signup->googleUrl($_POST, $_GET);
        }
        else if(self::check('/api/sign-in/google-url')){
            $signin->googleUrl($_POST, $_GET);
        }
        else if(self::check('/api/sign-up/google-callback', false)){
            $signup->googleCallback($_POST, $_GET);
        }
        else if(self::check('/api/sign-in/google-callback', false)){
            $signin->googleCallback($_POST, $_GET);
        }
        else if(self::check('/api/sign-up/facebook-post')){
            $signup->facebookPost($_POST, $_GET);
        }
        else if(self::check('/api/sign-in/facebook-post')){
            $signin->facebookPost($_POST, $_GET);
        }
        else {
            http_response_code(404);
            $main->error404();
        }
    }
}
