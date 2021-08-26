<?php
class Database {
    //les coordonnées de connexion
    private $host = "localhost";
    private $db_name = "api_db";
    private $dsn ;
    private $username = "root";
    private $password = "root";
    public $conn;


    // connexion à la base
    public function getConnection() {

        $this->conn = null;
        $this->dsn = "mysql:host=". $this->host. ";dbname=" . $this->db_name;
        try{
            $this->conn = new PDO($this->dsn, $this->username, $this->password);
            $this->conn ->exec("set names utf8");
        } catch (PDOException $exception) {
            echo "Connection error: " . $exception->getMessage();
        }
        return $this->conn;
    }
}