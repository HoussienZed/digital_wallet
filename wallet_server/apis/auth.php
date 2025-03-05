<?php
    require_once '../utils/jwt.php';

    

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