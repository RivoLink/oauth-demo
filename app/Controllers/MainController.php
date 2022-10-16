<?php

namespace App\Controllers;

use App\Config;

class MainController extends Controller {

    public function index(){
        return $this->redirect("/sign-in");
    }

    public function signIn(){
        $params = json_decode(
            file_get_contents(Config::FACEBOOK_AUTH),
            true
        );

        $app_id = get($params, "web|app_id");
        $app_version = get($params, "web|app_version");

        $this->view("views/sign-in.php", [
            "app_id" => $app_id,
            "app_version" => $app_version,
        ]);
    }

    public function signUp(){
        $params = json_decode(
            file_get_contents(Config::FACEBOOK_AUTH),
            true
        );

        $app_id = get($params, "web|app_id");
        $app_version = get($params, "web|app_version");

        $this->view("views/sign-up.php", [
            "app_id" => $app_id,
            "app_version" => $app_version,
        ]);
    }

    public function logout(){
        return $this->view("views/logout.php");
    }

    public function dashboard(){
        return $this->view("views/dashboard.php");
    }

    public function error404(){
        return $this->view("views/404.php");
    }

}
