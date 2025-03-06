<?php

    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
    header("Access-Control-Allow-Headers: Content-Type, Authorization");


    setcookie("auth_token", "", [
        'expires' => time() - 3600, // Set in the past to delete it
        'path' => '/',
        'httponly' => true,
        'secure' => true,
        'samesite' => 'Strict'
    ]);
    
    echo json_encode(['status' => 'logged_out']);


?>