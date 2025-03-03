<?php
    require_once '../utils/jwt.php';

    

    if(!isset($_COOKIE['auth_token'])) {
        echo json_encode(['status' => 'unauthorized']);
    } else {
        $decoded = verifyToken($_COOKIE['auth_token']);

        if($decoded) {
            echo json_encode(['status' => 'authorized']);
        } else {
            echo json_encode(['status' => 'unauthorized']);
        }
    }
?>