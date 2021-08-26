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

    public function create() {
        // requête d'insertion
        $query = "INSERT INTO
                " . $this->table_name . "
            SET
                name=:name, price=:price, description=:description, category_id=:category_id, created=:created";
        // on prépare la requête
        $stmt = $this->conn->prepare($query);

        //nettoyage
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->price = htmlspecialchars(strip_tags($this->price));
        $this->description = htmlspecialchars(strip_tags($this->description));
        $this->category_id = htmlspecialchars(strip_tags($this->category_id));
        $this->created = htmlspecialchars(strip_tags($this->created));

        // on bind
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":price", $this->price);
        $stmt->bindParam(":description", $this->description);
        $stmt->bindParam(":category_id", $this->category_id);
        $stmt->bindParam(":created", $this->created);

        // on lance la requête
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}
