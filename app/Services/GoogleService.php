<?php
namespace App\Services;

use App\Config;
use Google\Client;

class GoogleService {
    
    const SIGN_IN = "SIGN_IN";
    const SIGN_UP = "SIGN_UP";

    const PLATFORM = "Google";

    private static function getAuthPath(){
        return Config::GOOGLE_AUTH;
    }

    private static function getGoogleClient($type=self::SIGN_UP){
        if($type == self::SIGN_IN){
            return self::getSigninClient();
        }
        return self::getSignupClient();
    }

    private static function getSignupClient(){
        // Set the path to these credentials
        $client = new Client();
        $client->setAuthConfig(self::getAuthPath());

        // Set the scopes required for the API you are going to call
        // @see https://developers.google.com/identity/protocols/oauth2/scopes
        $client->addScope([
            "https://www.googleapis.com/auth/userinfo.profile",
            "https://www.googleapis.com/auth/userinfo.email",
        ]);

        // Prompt the user for consent.
        $client->setPrompt('consent');

        // Set your application's redirect URI
        $redirect_uri = base_url("/api/sign-up/google-callback");

        // Your redirect URI can be any registered URI, but in this example
        // we redirect back to this same page
        $client->setRedirectUri($redirect_uri);

        return $client;
    }

    private static function getSigninClient(){
        // Set the path to these credentials
        $client = new Client();
        $client->setAuthConfig(self::getAuthPath());

        // Set the scopes required for the API you are going to call
        // @see https://developers.google.com/identity/protocols/oauth2/scopes
        $client->addScope([
            "https://www.googleapis.com/auth/userinfo.profile",
        ]);

        // Prompt the user for consent.
        $client->setPrompt('consent');

        // Set your application's redirect URI
        $redirect_uri = base_url("/api/sign-in/google-callback");

        // Your redirect URI can be any registered URI, but in this example
        // we redirect back to this same page
        $client->setRedirectUri($redirect_uri);

        return $client;
    }

    public static function getGoogleOAuthUrl($type=self::SIGN_UP){
        $client = self::getGoogleClient($type);
        return $client->createAuthUrl();
    }

    public static function getGoogleUserInfo($data, $type=self::SIGN_UP){
        if(!isset($data['code'])){
            return [];
        }

        $client = self::getGoogleClient($type);
        $token = $client->fetchAccessTokenWithAuthCode($data['code']);

        if(isset($token['access_token'])){
            $val = $token['access_token'];
            $url = "https://www.googleapis.com/oauth2/v1/userinfo?alt=json&access_token=$val";
        
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        
            $resp = curl_exec($curl);
            curl_close($curl);
        
            $infos = json_decode($resp, true);
            $infos = self::extractData($infos);

            return $infos;
        }

        return [];
    }

    private static function extractData($infos){
        if(!is_array($infos)){
            return [];
        }

        return [
            "platform" => self::PLATFORM,
            "google_id" => get($infos, "id"),
            "facebook_id" => null,
            "name" => get($infos, "name"),
            "email" => get($infos, "email"),
            "password" => gen_pwd(),
        ];
    }
}
