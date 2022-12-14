<?php

namespace App;

use PDO;

/**
 * SQLite connnection
 */
class SQLite {

    /**
     * PDO instance
     * @var type 
     */
    private static $pdo;

    /**
     * return in instance of the PDO object that connects to the SQLite database
     * @return PDO
     */
    public static function connect(){
        if(self::$pdo == null){
            self::$pdo = new PDO(Config::DATABASE_URL);
        }
        return self::$pdo;
    }

    public static function createTable(){
        self::$pdo->query(
            "CREATE TABLE IF NOT EXISTS user (
                id TEXT PRIMARY KEY,
                google_id TEXT,
                facebook_id TEXT,
                name TEXT NOT NULL,
                email TEXT UNIQUE,
                password TEXT,
                platform TEXT
            );"
        );
    }

    public static function findByEmail($email){
        $query = "SELECT * FROM user WHERE email = :email";
        $param = ["email" => $email];

        $stmt = self::$pdo->prepare($query);
        $stmt->execute($param);

        $result = $stmt->fetchAll();

        if($result && isset($result[0])){
            return $result[0];
        }

        return null;
    }

    public static function find($id=null, $google_id=null, $facebook_id=null){
        $param = [];
        $query = "SELECT * FROM user";

        if(!$id && !$google_id && !$facebook_id){
            return null;
        }
        else if($id){
            $param = ['id' => $id];
            $query = "SELECT * FROM user WHERE id = :id";
        }
        else if($google_id){
            $param = ['google_id' => $google_id];
            $query = "SELECT * FROM user WHERE google_id = :google_id";
        }
        else if($facebook_id){
            $param = ['facebook_id' => $facebook_id];
            $query = "SELECT * FROM user WHERE facebook_id = :facebook_id";
        }

        $stmt = self::$pdo->prepare($query);
        $stmt->execute($param);

        $result = $stmt->fetchAll();

        if($result && isset($result[0])){
            return $result[0];
        }

        return null;
    }

    public static function list($exclude_id=null){
        $param = [];
        $query = "SELECT * FROM user";

        if($exclude_id){
            $param = ['id' => $exclude_id];
            $query = "SELECT * FROM user WHERE id <> :id";
        }

        $stmt = self::$pdo->prepare($query);
        $stmt->execute($param);

        $result = $stmt->fetchAll();
        return $result;
    }

    public static function insert($data){
        $stmt = self::$pdo->prepare(
            "INSERT INTO user (id, name, email, password, platform, google_id, facebook_id)
             VALUES (:id, :name, :email, :password, :platform, :google_id, :facebook_id);"
        );

        $user = array_merge($data, [
            "id" => uniqid(),
        ]);
        
        if($stmt->execute($user)){
            return $user;
        }

        return null;
    }

    public static function delete($id=null){
        if(!$id){
            return true;
        }

        $param = ['id' => $id];
        $query = "DELETE FROM user WHERE id = :id";

        $stmt = self::$pdo->prepare($query);
        $stmt->execute($param);

        return true;
    }

}