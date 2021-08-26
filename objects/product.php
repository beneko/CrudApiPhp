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

    // lecture des produits
    public function read() {
        // requête select avec jointure
        $query = "SELECT
            c.name as category_name, p.id, p.name, p.description, p.price, p.category_id, p.created
            FROM "
            . $this->table_name . " p
            LEFT JOIN
            categories c ON p.category_id = c.id
            ORDER BY
            p.created DESC";

        // on prépare la requête
        $stmt = $this->conn->prepare($query);

        // on execute la requête
        $stmt->execute();

        return $stmt;
    }
}
