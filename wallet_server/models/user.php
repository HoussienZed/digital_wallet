<?php

    use Firebase\JWT\JWT;
    use Firebase\JWT\Key;

    $conn = include('../connection/connection.php');
    require_once '../utils/jwt.php';
    include('C:/xampp/htdocs/digital_wallet/vendor/autoload.php');

    class User {

        public static function createUser ($conn, $fullName, $password, $repeatedPassword, $email, $phoneNumber, $address, $profilePicture) {

           if(empty($fullName) || empty($password) || empty($repeatedPassword) || empty($email) || empty($phoneNumber) || empty($address)) {
                return ['status' => 'error', 'message' => 'All fields are required'];
            } 

            if($password !== $repeatedPassword) {
                return ['status' => 'error', 'message' => 'Passwords do not match'];
            }

            $emailCheckQuery = $conn->prepare("SELECT * FROM users WHERE email = ?");
            $emailCheckQuery->bind_param("s", $email);
            $emailCheckQuery->execute();

            
            $result = $emailCheckQuery->get_result();
            

            if($result->num_rows > 0) {
                $user = $result->fetch_assoc();
                return ['status' => 'error', 'message' => 'Email is already registered'];
            } 
            
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            
            $uploadDir = "../uploads/";
            $defaultImage =  "../wallet_client/assets/illustration-businessman_53876-5856.avif";

            $profilePicturePath = $defaultImage;

            if($profilePicture && $profilePicture['error'] === 0) { //if no picture uploaded then $profilePicture["error"] = 4 and the code below wont execute
                $fileName = uniqid() . '_' . basename($profilePicture['name']); // to generate a unique name 
                $profilePicturePath = $uploadDir . $fileName;
                

                //checking if the uploaded picture is uploaded to the server, to the permenant path $profilePicturePath
                if(!move_uploaded_file($profilePicture['tmp_name'], $profilePicturePath)) { 
                    return ['status' => 'error', 'message' => 'Failed to upload profile pictaure'];
                }
            }

            $query = $conn->prepare("INSERT INTO users (full_name, email, password, phone_number, address, profile_picture) VALUES (?, ?, ?, ?, ?, ?)");
            $query -> bind_param("ssssss", $fullName, $email, $hashedPassword, $phoneNumber, $address, $profilePicturePath);
            

            //the returned associative array is sent as json object to the frontend
            if($query->execute()) { // $query->execute() returns true if query executed correctly and false if not
                return ["status" => "success", 'message' => 'User registered successfully'];
            } else {
                return ['status' => 'error', 'message' => 'User not registered successfully'];
            }
        }

        public static function signIn ($conn, $emailOrPhoneNumber, $password) {

            
            if (filter_var($emailOrPhoneNumber, FILTER_VALIDATE_EMAIL)) {
                $credentialsCheckQuery = $conn->prepare("SELECT * FROM users WHERE email = ?");
            } else {
                $credentialsCheckQuery = $conn->prepare("SELECT * FROM users WHERE phone_number = ?");
            }

            $credentialsCheckQuery->bind_param("s", $emailOrPhoneNumber);
            $credentialsCheckQuery->execute();

            $result = $credentialsCheckQuery->get_result();

            if($result->num_rows > 0) {
                
                $user = $result->fetch_assoc(); //$user is the record searched for in the db

                if(password_verify($password, $user['password'])) {

                    

                    
                    //generate JWT
                    $secretKey = 'secretKey'; //used to sign the JWT preferred not to be hard-coded, will learn how later
                    $payload = [
                        'iss' => 'zwallet.com', //application name or domain
                        'aud' => 'server', //the recipient of the jwt
                        'iat' => time(),
                        'exp' => time() + 600,
                        'userId' => $user['user_id']
                    ];

                    $token = JWT::encode($payload, $secretKey, 'HS256');

                    setcookie("auth_token", $token, [
                        'expires' => time() + 600,  // Token expires in 10 minutes
                        'path' => '/',  // Available to all pages on the domain
                        'httponly' => true,  // Prevents JavaScript access (protects against XSS)
                        'secure' => true,    // Ensures it's only sent over HTTPS
                        'samesite' => 'Strict' 
                    ]);

                    return ['status' => 'success', 'message' => 'login successfully', 'userId' => $user['user_id']];
                } else {
                    return ['status' => 'error', 'message' => 'Password doesnt match email/phone number'];
                }
            } else {
                return ['status' => 'error', 'message' => 'Email/ phone number not found'];
            }
        }

        public static function getUserById($conn, $userId) {
            $query = $conn -> prepare("SELECT full_name, email, phone_number, address, profile_picture FROM users WHERE user_id = ?");
            $query->bind_param('i', $userId);

            $query->execute();

            $result = $query->get_result();
            $user = $result->fetch_assoc();

           /*  $secretKey = 'secretKey'; //used to sign the JWT preferred not to be hard-coded, will learn how later
            $payload = [
                        'iss' => 'zwallet.com', //application name or domain
                        'aud' => 'server', //the recipient of the jwt
                        'iat' => time(),
                        'exp' => time() + 600,
                        'userId' => $user['id']
                    ];

            $token = JWT::encode($payload, $secretKey, 'HS256');

            setcookie("auth_token", $token, [
                        'expires' => time() + 600,  // Token expires in 10 minutes
                        'path' => '/',  // Available to all pages on the domain
                        'httponly' => true,  // Prevents JavaScript access (protects against XSS)
                        'secure' => true,    // Ensures it's only sent over HTTPS
                        'samesite' => 'Strict' 
                    ]);

            */
            return $user;
        } 
       
    }

?>