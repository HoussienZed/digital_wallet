<?php
    $conn = require("../connection/connection.php");
    require("C:/xampp/htdocs/digital_wallet/wallet_server/models/user.php");

    header('Content-Type: application/json');
     /* header("Access-Control-Allow-Origin: *"); //allow any origin.
    header("Access-Control-Allow-Methods: POST, GET, DELETE");
    header("Content-Type: application/json");
    header("Access-Control-Allow-Headers: Content-Type"); */
    
    $data = json_decode(file_get_contents('php://input'), true);

    $userId = $data['user'];
    
    $result = User::getUserById($conn, $userId);

    echo json_encode($result);
?>