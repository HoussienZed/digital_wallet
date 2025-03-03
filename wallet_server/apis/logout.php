<?php

    /* header('Content-Type: application/json');

    $conn = include("../connection/connection.php");
    require_once '../utils/jwt.php';
    require_once 'C:/xampp/htdocs/digital_wallet/vendor/autoload.php';

    unset($_SESSION['token']);
    

    $result = ['status' => 'session destroyed'];

    echo json_encode($result);

    session_destroy(); */

    setcookie("auth_token", "", [
        'expires' => time() - 3600, // Set in the past to delete it
        'path' => '/',
        'httponly' => true,
        'secure' => true,
        'samesite' => 'Strict'
    ]);
    
    echo json_encode(['status' => 'logged_out']);


?>