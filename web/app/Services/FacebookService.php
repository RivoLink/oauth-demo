<?php

namespace App\Services;

class FacebookService {

    const SIGN_IN = "SIGN_IN";
    const SIGN_UP = "SIGN_UP";

    const PLATFORM = "Facebook";

    public static function isValidUser($data){
        $userID = get($data, "authResponse|userID");
        $accessToken = get($data, "authResponse|accessToken");

        if(!$userID || !$accessToken){
            return false;
        }

        $url = "https://graph.facebook.com/me?fields=id&access_token=$accessToken";
    
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    
        $resp = curl_exec($curl);
        curl_close($curl);
    
        $infos = json_decode($resp, true);

        if(is_array($infos)){
            $facebookID = get($infos, "id");
            return $facebookID && ($facebookID === $userID);
        }

        return false;
    }

    public static function getFacebookUserInfo($data, $type=self::SIGN_UP){
        $userID = get($data, "authResponse|userID");
        $accessToken = get($data, "authResponse|accessToken");

        if(!$userID || !$accessToken){
            return [];
        }

        if($type == self::SIGN_IN){
            $url = "https://graph.facebook.com/me?fields=id&access_token=$accessToken";
        }
        else {
            $fields = implode(",", [
                "id",
                "email",
                "last_name",
                "first_name",
            ]);

            $url = "https://graph.facebook.com/me?fields=$fields&access_token=$accessToken";
        }

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    
        $resp = curl_exec($curl);
        curl_close($curl);
    
        $infos = json_decode($resp, true);

        if(is_array($infos)){
            $facebookID = get($infos, "id");
            
            if($facebookID && ($facebookID === $userID)){
                return self::extractData($infos);;
            }
        }

        return [];
    }

    public static function extractData($infos){
        if(!is_array($infos)){
            return [];
        }

        $infos["name"] = trim(
            get($infos, "first_name") ." ".
            get($infos, "last_name")
        );

        return [
            "platform" => self::PLATFORM,
            "google_id" => null,
            "facebook_id" => get($infos, "id"),
            "name" => get($infos, "name"),
            "email" => get($infos, "email"),
            "password" => gen_pwd(),
        ];
    }

}
