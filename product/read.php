<?php
// Les headers dont nous avons besoin
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// inclusion de database et product
include_once '../config/database.php';
include_once '../objects/product.php';

// instanciation de database et de product
$database = new Database();
$db = $database->getConnection();

// On initialise product
$product = new Product($db);

// le query
$stmt = $product->read();
$num = $stmt->rowCount();

// on regarde si on a plus d'un résultat
if($num>0){

    // tableau de produits
    $products_arr = array();
    $products_arr["records"]=array();

    // on récupère le contenu de la table
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);

        $product_item = array(
            "id" => $id,
            "name" => $name,
            "description" => $price,
            "category_id" => $category_id,
            "category_name" => $category_name
        );

        array_push($products_arr["records"], $product_item);
    }

    // on envoie la réponse http à 200 OK
    http_response_code(200);

    // on renvoie la réponse en Json
    echo json_encode($products_arr);

}