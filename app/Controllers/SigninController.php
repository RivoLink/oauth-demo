<?php

namespace App\Controllers;

use App\SQLite;
use App\Services\AuthService;
use App\Services\GoogleService;
use App\Services\FacebookService;

class SigninController extends Controller {

    const TYPE = GoogleService::SIGN_IN;
   
    public function googleUrl($data, $query){
        $url = GoogleService::getGoogleOAuthUrl(self::TYPE);

        return $this->json([
            "status" => 200,
            "content" => [
                "url" => $url
            ]
        ]);
    }

    public function googleCallback($data, $query){
        $infos = GoogleService::getGoogleUserInfo($query, self::TYPE);
        
        $user = SQLite::find(null, get($infos, "google_id"));
        $auth = AuthService::setAuth($user);
        
        if($auth){
            return $this->redirect("/dashboard");
        }

        return $this->redirect("/sign-in", [
            "An error occured, please try again"
        ]);
    }

    public function facebookPost($data, $query){
        $valid = FacebookService::isValidUser($data);

        if(!$valid){
            return $this->redirect("/sign-in", [
            "An error occured, please try again"
        ]);
        }

        $user = SQLite::find(null, get($data, "authResponse|userID"));
        $auth = AuthService::setAuth($user);
        
        if($auth){
            return $this->redirect("/dashboard");
        }

        return $this->redirect("/sign-in", [
            "An error occured, please try again"
        ]);
    }

}
