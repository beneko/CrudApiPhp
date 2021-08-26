<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods:POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type,Access-Control-Allow-Headers,Authorization,X-Requested-Width");


// on se connecte à la base
include_once '../config/database.php';

// l'objet product
include_once '../objects/product.php';

$database = new Database();
$db = $database->getConnection();

$product = new Product($db);

// on récupère les données du post
$data = json_decode(file_get_contents("php://input"));

// on s'assure que ce n'est pas vide
if (
    !empty($data->name) &&
    !empty($data->price) &&
    !empty($data->description) &&
    !empty($data->category_id)
) {
    $product->name = $data->name;
    $product->price = $data->price;
    $product->description = $data->description;
    $product->category_id = $data->category_id;
    $product->created = date('Y-m-d H:i:s');

    if ($product->create()) {

        //on envoie le code 201
        http_response_code(201);

        // on averti l'utilisateur
        echo json_encode(array("message" => "Produit Créé."));
    } else {
        // on envoie le code 503
        http_response_code(503);
        // on averti l'utilisateur
        echo json_encode(["message" => "Impossible de créer le produit!"]);
    }
} else {
    // on envoie le code 400 - bad request
    http_response_code(400);
    // on averti l'utilisateur
    echo json_encode(["message" => "Impossible de créer le produit! les données sont incomplètes!"]);
}