<?php
    $conn = require("../connection/connection.php");
    require("C:/xampp/htdocs/digital_wallet/wallet_server/models/user.php");
    
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
    header("Access-Control-Allow-Headers: Content-Type, Authorization");
    header('Content-Type: application/json');
    
    
    $data = json_decode(file_get_contents('php://input'), true);

    $userId = $_POST['userId'];
    
    $result = User::getUserById($conn, $userId);

    echo json_encode($result);
?>