<?php

namespace App\Controllers;

use App\Config;
use App\SQLite;
use App\Services\AuthService;
use App\Services\SigninService;
use App\Services\SignupService;

class MainController extends Controller {

    public function index(){
        return $this->redirect("/sign-in");
    }

    public function logout(){
        return $this->view("views/logout.php");
    }

    public function privacyPolicy(){
        return $this->view("views/privacy-policy.php");
    }

    public function error404(){
        return $this->view("views/404.php");
    }

    public function dashboard($user_id){
        $users = SQLite::list();
        $csrf = AuthService::getCSRF();

        return $this->view("views/dashboard.php", [
            "csrf" => $csrf,
            "users" => $users,
        ]);
    }

    public function deleteAccount($post, $query, $user_id){
        $key = get($post, "csrf");
        $csrf = AuthService::getCSRF();

        if($key === $csrf){
            SQLite::delete($user_id);
            return $this->redirect("/logout");
        }

        return $this->throwAccessDenied();
    }

    public function signIn($post, $query){
        $errors = $this->getErrors();
        
        $params = json_decode(
            file_get_contents(Config::FACEBOOK_AUTH),
            true
        );

        $app_id = get($params, "web|app_id");
        $app_version = get($params, "web|app_version");

        if(SigninService::isSubmitted($post)){
            list($valid, $user, $errors) = SigninService::isValid($post);
            
            if($valid){
                $auth = AuthService::setAuth($user);

                if($auth){
                    $this->redirect("/dashboard");
                }

                $errors[] = "An error occured, please try again";
            }
        }

        $this->view("views/sign-in.php", [
            "errors" => $errors,
            "app_id" => $app_id,
            "app_version" => $app_version,
        ]);
    }

    public function signUp($post, $query){
        $errors = $this->getErrors();

        $fields = [
            "name" => null,
            "email" => null,
        ];

        $params = json_decode(
            file_get_contents(Config::FACEBOOK_AUTH),
            true
        );

        $app_id = get($params, "web|app_id");
        $app_version = get($params, "web|app_version");

        if(SignupService::isSubmitted($post)){
            list($valid, $errors, $fields) = SignupService::isValid($post);
            
            if($valid){
                $user = SignupService::register($post);
                $auth = AuthService::setAuth($user);

                if($auth){
                    $this->redirect("/dashboard");
                }

                $errors[] = "An error occured, please try again";
            }
        }

        $this->view("views/sign-up.php", [
            "errors" => $errors,
            "fields" => $fields,
            "app_id" => $app_id,
            "app_version" => $app_version,
        ]);
    }
}
