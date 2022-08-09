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
    private $pdo;

    /**
     * return in instance of the PDO object that connects to the SQLite database
     * @return \PDO
     */
    public function connect(){
        if($this->pdo == null){
            $this->pdo = new PDO(Config::DATABASE_URL);
        }
        return $this->pdo;
    }

    public function createTableUser(){
        $this->pdo->query(
            "CREATE TABLE IF NOT EXISTS user (
                id TEXT PRIMARY KEY,
                google_id TEXT NOT NULL,
                first_name TEXT NOT NULL,
                last_name TEXT,
                email TEXT UNIQUE,
                phone TEXT UNIQUE
            );"
        );
    }

    public function listUsers($id=null, $google_id=null){
        $param = [];
        $query = "SELECT * FROM user";

        if($id){
            $param = ['id' => $id];
            $query = "SELECT * FROM user WHERE id = :id";
        }
        else if($google_id){
            $param = ['google_id' => $google_id];
            $query = "SELECT * FROM user WHERE google_id = :google_id";
        }

        $stmt = $this->pdo->prepare($query);
        $stmt->execute($param);

        $result = $stmt->fetchAll();
        var_dump($result);

        return $result;
    }

    public function insertUser($google_id, $first_name, $last_name=null, $email=null, $phone=null){
        $stmt = $this->pdo->prepare(
            "INSERT INTO user (id, google_id, first_name, last_name, email, phone)
             VALUES (:id, :google_id, :first_name, :last_name, :email, :phone);"
        );
        
        $result = $stmt->execute([
            "id" => uniqid(),
            "google_id" => $google_id,
            "first_name" => $first_name,
            "last_name" => $last_name,
            "email" => $email,
            "phone" => $phone,
        ]);
    }


}