<?php

// les headers
header("Access-Control-Allow-Origin:*");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods:POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type,Access-Control-Allow-Headers,Authorization,X-Requested-Width");

include_once '../config/database.php';
include_once '../objects/product.php';

$database = new Database();
$db = $database->getConnection();

$product = new Product($db);

// on récupère les données du post
$data = json_decode(file_get_contents("php://input"));
if ($data != null) {
    $product->id = $data->id;
    $product->name = $data->name;
    $product->price = $data->price;
    $product->description = $data->description;
    $product->category_id = $data->category_id;

    if ($product->update()) {
        http_response_code(200);

        echo json_encode(["message" => "Produit mis à jour"]);
    } else {
        http_response_code(503);

        echo json_encode(["message" => "Le produit n'a pas été mis à jour."]);
    }
} else {
    http_response_code(503);

    echo json_encode(["message" => "Nous n'avons pas compris votre demande"]);
}