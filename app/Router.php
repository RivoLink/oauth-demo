<?php

namespace App;

class Router {
   
    public static function handle(){
        switch($_SERVER['REQUEST_URI']){

            case '':
            case '/':
            case '/sign-in':
                require 'views/sign-in.php';
                break;
            
            case '/sign-up':
                require 'views/sign-up.php';
                break;

            case '/logout':
                require 'views/logout.php';
                break;

            case '/dashboard':
                require 'views/dashboard.php';
                break;

            default:
                http_response_code(404);
                require 'views/404.php';
                break;

        }
    }
}
