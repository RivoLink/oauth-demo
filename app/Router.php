<?php

namespace App;

class Router {
   
    public static function handle(){
        switch($_SERVER['REQUEST_URI']){

            case '':
            case '/':
                require 'views/index.php';
                break;

            case '/logout':
                require 'views/logout.php';
                break;

            case '/register':
                require 'views/register.php';
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
