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
        
        $auth = false;
        $user = SQLite::find(null, get($infos, "google_id"));

        if(!$user){
            $user = SQLite::insert($infos);
        }

        $auth = AuthService::setAuth($user);

        if($auth){
            return $this->redirect("/dashboard");
        }

        return $this->redirect("/sign-up");
    }

    public function facebookPost($data, $query){
        $infos = FacebookService::getFacebookUserInfo($data);

        if(!$infos){
            return $this->redirect("/sign-in");
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

        return $this->redirect("/sign-up");
    }

}
