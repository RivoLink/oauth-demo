<?php

namespace App;

class Config {
   
    const GOOGLE_AUTH = "private/google-auth.json";
    const FACEBOOK_AUTH = "private/facebook-auth.json";

    const DATABASE_URL = 'sqlite:db/phpsqlite.db';

    public static function check(){
        if(!is_file(self::GOOGLE_AUTH)){
            http_response_code(505);
            echo "File not found : ".self::GOOGLE_AUTH;
            die();
        }
        else if(!is_file(self::FACEBOOK_AUTH)){
            http_response_code(505);
            echo "File not found : ".self::FACEBOOK_AUTH;
            die();
        }
    }

}
