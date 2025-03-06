<?php


require('C:/xampp/htdocs/digital_wallet/vendor/autoload.php');

use Firebase\JWT\JWT;
use Firebase\JWT\Key;




function verifyToken($token) {

    $secretKey = 'secretKey';

    if(!$token) {
        return null;
    }
    
    $decoded = JWT::decode($token, new Key($secretKey, 'HS256'));
    
    if(is_object($decoded)) {
        return $decoded;
    } else {
        return null;
    }
}

?>