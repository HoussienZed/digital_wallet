<?php

    include("../wallet_server/connection/connection.php");
    include("../wallet_Server/models/user.php");

    header('Content-Type: application/json');

    $fullName = htmlspecialchars($_POST["fullName"]);
    $password = $_POST["password"];
    $repeatedPassword = $_POST["repeatedPassword"];
    $email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);
    $phoneNumber = htmlspecialchars($_POST["phoneNumber"]);
    $address = htmlspecialchars($_POST["address"]);
    $profilePicture = $_FILES["profilePicture"];
    
    $result = User::createUser($fullName, $password, $repeatedPassword, $email, $phoneNumber, $address, $profilePicture);

    echo json_encode($result);

?>