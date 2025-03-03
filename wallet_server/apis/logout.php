<?php

    session_start();

    $conn = include("../connection/connection.php");
    require_once '../utils/jwt.php';
    include('C:/xampp/htdocs/digital_wallet/vendor/autoload.php');
    include('C:/xampp/htdocs/digital_wallet/wallet_server/apis/auth.php');

    unset($_SESSION['token']);
    session_destroy();


?>