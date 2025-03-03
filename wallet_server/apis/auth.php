<?php

    session_start();

    include('../utils/jwt.php');

    if(!isset($_SESSION['token'])) {
        header('Location: ../wallet_client/signin.html');
        exit();
    }

    $decoded = verifyToken($_SESSION['token']);

    if(!$decoded) {
        header('Location: ../wallet_client/sigin.html');
        exit();
    }

?>