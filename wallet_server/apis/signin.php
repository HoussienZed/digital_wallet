<?php

    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
    header("Access-Control-Allow-Headers: Content-Type, Authorization");

    $conn = require("../connection/connection.php");
    require("C:/xampp/htdocs/digital_wallet/wallet_server/models/user.php");

    header('Content-Type: application/json');

    $emailOrPhoneNumber = htmlspecialchars($_POST["emailOrPhoneNumber"]);
    $password = $_POST["password"];

    $result = User::signIn($conn, $emailOrPhoneNumber, $password);

    echo json_encode($result);

?>