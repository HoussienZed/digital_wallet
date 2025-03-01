<?php

    include(__DIR__ . "/../connection/connection.php");
    include(__DIR__ . "/../models/user.php");

    header('Content-Type: application/json');

    // Debugging: Log received data
    error_log("Received POST data: " . print_r($_POST, true));
    error_log("Received FILES data: " . print_r($_FILES, true));

    $fullName = htmlspecialchars($_POST["fullName"]);
    $password = $_POST["password"];
    $repeatedPassword = $_POST["repeatedPassword"];
    $email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);
    $phoneNumber = htmlspecialchars($_POST["phoneNumber"]);
    $address = htmlspecialchars($_POST["address"]);
    $profilePicture = $_FILES["profilePicture"];
    
    // Debugging: Log processed data
    error_log("Processed data - Full Name: $fullName, Email: $email, Phone: $phoneNumber");

    $result = User::createUser($conn, $fullName, $password, $repeatedPassword, $email, $phoneNumber, $address, $profilePicture);

    // Debugging: Log the result
    error_log("Result: " . print_r($result, true));

    echo json_encode($result);

?>