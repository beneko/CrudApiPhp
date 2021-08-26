<?php
class Product {

    // connexion à la base
    private $conn;
    private $table_name = "products";

    // membres de l'objet
    public $id;
    public $name;
    public $description;
    public $price;
    public $category_id;
    public $category_name;
    public $created;

    // un constructeur avec $db comme connexion à la base
    public function __construct($db) {
        $this->conn = $db;
    }
}
