<?php

    session_start();
    include('../utils/jwt.php');

    if(!isset($_SESSION['token'])) {
        header('Location: ../wallet_client/sgingin.html');
        exit();
    }

    $decoded = verifyToken($_SESSION['token']);

    if(!$decoded) {
        header('Location: ../wallet_client/sgingin.html');
        exit();
    }

?>