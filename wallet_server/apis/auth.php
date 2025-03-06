<?php
    require ('../utils/jwt.php');

    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
    header("Access-Control-Allow-Headers: Content-Type, Authorization");

    

    if(!isset($_COOKIE['auth_token'])) {
        echo json_encode(['status' => 'unauthorized']);
    } else {
        $decoded = verifyToken($_COOKIE['auth_token']);
        
        $userId = $decoded->userId;
        if($decoded) {
            echo json_encode(['status' => 'authorized', 'userId'=>$userId]);
        } else {
            echo json_encode(['status' => 'unauthorized']);
        }
    }
?>