<?php

/* include('../digital_wallet/vendor/autoload.php');
 */include('C:/xampp/htdocs/digital_wallet/vendor/autoload.php');

use Firebase\JWT\JWT;
use Firebase\JWT\KEY;

function verifyToken($token) {
    try {
        $decoded = JWT::decode($token, new Key($secretKey, 'HS256'));
        return $decoded;
    } catch (Exception $e) {
        return null;
    }
}

?>