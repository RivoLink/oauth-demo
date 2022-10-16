<?php

namespace App\Services;

use App\SQLite;

class SignupService {

    const PLATFORM = "Default";

    public static function register($post){
        return SQLite::insert([
            "platform" => self::PLATFORM,
            "google_id" => null,
            "facebook_id" => null,
            "name" => get($post, "name"),
            "email" => get($post, "email"),
            "password" => hash_pwd(get($post, "password")),
        ]);
    }

    public static function isSubmitted($post){
        return (
            isset($post["name"]) ||
            isset($post["email"]) ||
            isset($post["password"]) ||
            isset($post["cpassword"])
        );
    }

    public static function isValid($post){
        $fields = [
            "name" => get($post, "name"),
            "email" => get($post, "email"),
            "password" => get($post, "password"),
            "cpassword" => get($post, "cpassword"),
        ];

        $valid = false;
        $errors = [];

        foreach($fields as $field => $value){
            if($field == "email" && $value){
                if(SQLite::findByEmail(get($post, "email"))){
                    $errors[] = "Email already exists";
                }
            }
            if($field == "password" && $value){
                if(!req_pwd(get($post, "password"))){
                    $errors[] = "Password should have at least one special character and one number";
                }
            }
            if($field == "cpassword"){
                if($value !== $fields["password"]){
                    $errors[] = "Password confirmation doesn't match Password";
                }
            }
            else if(!$value){
                $errors[] = ucfirst($field)." required";
            }
        }

        if(!$errors || !isset($errors[0])){
            $valid = true;
        }

        $fields = [
            "name" => get($post, "name"),
            "email" => get($post, "email"),
        ];
        
        return [$valid, $errors, $fields];
    }

}
