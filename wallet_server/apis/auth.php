<?php

    session_start();

    include('../utils/jwt.php');

    if(!isset($_SESSION['token'])) {
        echo json_encode(['status' => 'unauthorized']);
    }

    $decoded = verifyToken($_SESSION['token']);

    if(!$decoded) {
        echo json_encode(['status' => 'unauthorized']);
    }

?>