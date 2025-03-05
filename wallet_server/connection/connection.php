<?php

    $host = "localhost";
    $name = "digital_wallet";
    $user = "root";
    $password = "";

    $conn = new mysqli($host, $user, $password, $name);

    if($conn->connect_error) {
        die("connection failed");
    }

    return $conn;

?>