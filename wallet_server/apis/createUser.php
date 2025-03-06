<?php

    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
    header("Access-Control-Allow-Headers: Content-Type, Authorization");


    $conn = require("../connection/connection.php");
    require("../models/user.php");

    header('Content-Type: multipart/form-data');

    $fullName = htmlspecialchars($_POST["fullName"]);
    $password = $_POST["password"];
    $repeatedPassword = $_POST["repeatedPassword"];
    $email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);
    $phoneNumber = htmlspecialchars($_POST["phoneNumber"]);
    $address = htmlspecialchars($_POST["address"]);
    $profilePicture = $_FILES["profilePicture"];

    $result = User::createUser($conn, $fullName, $password, $repeatedPassword, $email, $phoneNumber, $address, $profilePicture);
    

    echo json_encode($result);

?>