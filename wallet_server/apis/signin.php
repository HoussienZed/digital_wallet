<?php
    $conn = include("../connection/connection.php");
    include("C:/xampp/htdocs/digital_wallet/wallet_server/models/user.php");

    header('Content-Type: application/json');

    $emailOrPhoneNumber = htmlspecialchars($_POST["emailOrPhoneNumber"]);
    $password = $_POST["password"];

    $result = User::signIn($conn, $emailOrPhoneNumber, $password);

    echo json_encode($result);

?>