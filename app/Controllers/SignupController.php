<?php

namespace App\Controllers;

use App\SQLite;
use App\Services\AuthService;
use App\Services\FacebookService;
use App\Services\GoogleService;

class SignupController extends Controller {
   
    public function googleUrl($data, $query){
        $url = GoogleService::getGoogleOAuthUrl();

        return $this->json([
            "status" => 200,
            "content" => [
                "url" => $url
            ]
        ]);
    }

    public function googleCallback($data, $query){
        $infos = GoogleService::getGoogleUserInfo($query);

        if(!$infos){
            return $this->throwAccessDenied();
        }

        if(SQLite::findByEmail(get($infos, "email"))){
            return $this->redirect("/sign-up", [
                "Email already exists, please use another Google Account"
            ]);
        }
        
        $auth = false;
        $user = SQLite::find(null, get($infos, "google_id"));

        if(!$user){
            $user = SQLite::insert($infos);
        }

        $auth = AuthService::setAuth($user);

        if($auth){
            return $this->redirect("/dashboard");
        }

        return $this->redirect("/sign-up", [
            "An error occured, please try again"
        ]);
    }

    public function facebookPost($post, $query){
        $infos = FacebookService::getFacebookUserInfo(
            json_decode(get($post, "data"), true)
        );

        if(!$infos){
            return $this->throwAccessDenied();
        }

        if(SQLite::findByEmail(get($infos, "email"))){
            return $this->redirect("/sign-up", [
                "Email already exists, please use another Facebook Account"
            ]);
        }

        $auth = false;
        $user = SQLite::find(null, get($infos, "facebook_id"));

        if(!$user){
            $user = SQLite::insert($infos);
        }

        $auth = AuthService::setAuth($user);
        
        if($auth){
            return $this->redirect("/dashboard");
        }

        return $this->redirect("/sign-up", [
            "An error occured, please try again"
        ]);
    }

}
