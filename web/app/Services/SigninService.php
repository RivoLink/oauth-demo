<?php

namespace App\Services;

use App\SQLite;

class SigninService {

    public static function isSubmitted($post){
        return (
            isset($post["name"]) ||
            isset($post["email"])
        );
    }

    public static function isValid($post){
        $email = get($post, "email");
        $password = get($post, "password");

        if(!$email || !$password){
            return [
                false,
                null,
                ["Email and Password required"]
            ];
        }

        $user = SQLite::findByEmail($email);
        $hash = get($user, "password");

        if(!$user || !verify_pwd($password, $hash)){
            return [
                false,
                null,
                ["Invalid credentials"]
            ];
        }

        return [true, $user, []];
    }

}
