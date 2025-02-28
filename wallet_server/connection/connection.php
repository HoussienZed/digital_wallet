<?php

    $host = "localhost:3307";
    $name = "digital_wallet";
    $user = "root";
    $password = "";

    $mysqli = new mysqli($host, $user, $password, $name);

    if(!isset($mysqli)) {
        die("connection is successful");
    }

?>