<?php

    $conn = include("../connection/connection.php");
    require_once '../utils/jwt.php';
    include('C:/xampp/htdocs/digital_wallet/vendor/autoload.php');

    unset($_SESSION['token']);
    session_destroy();


?>