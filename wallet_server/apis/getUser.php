<?php
    $conn = include("../connection/connection.php");
    include("C:/xampp/htdocs/digital_wallet/wallet_server/models/user.php");

    header('Content-Type: application/json');

    $userId = $_POST['userId'];

    $result = User::getUserById($conn, $userId);

    echo json_encode($result);
?>