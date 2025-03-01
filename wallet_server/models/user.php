<?php

    $conn = include("../connection/connection.php");

    class User {
        private $conn;

        public function __construct($conn) {
            $this->conn = $conn;  // Assign the database connection
        }

        public static function createUser ($conn,$fullName, $password, $repeatedPassword, $email, $phoneNumber, $address, $profilePicture) {

            if($password !== $repeatedPassword) {
                return ['status' => 'error', 'message' => 'Passwords do not match'];
            }

            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            
            $uploadDir = "../uploads/";
            $defaultImage =  "../wallet_client/assets/illustration-businessman_53876-5856.avif";

            $profilePicturePath = $defaultImage;

            if($profilePicture && $profilePicture['error'] === UPLOAD_ERR_OK) {
                $fileName = uniqid() . '_' . basename($profilePicture['name']); // to generate a unique name 
                $profilePicturePath = $uploadDir . $fileName;
                
                if(!move_uploaded_file($profilePicture['tmp_name'], $profilePicturePath)) {
                    return ['status' => 'error', 'message' => 'Failed to upload profile pictaure'];
                }
            }

            echo ($profilePicturePath);

            $query = $conn->prepare("INSERT INTO users (full_name, email, password, phone_number, address, profile_picture) VALUES (?, ?, ?, ?, ?, ?)");
            $query -> bind_param("ssssss", $fullName, $email, $hashedPassword, $phoneNumber, $address, $profilePicturePath);
            
            if($query->execute()) {
                return ['status' => 'success', 'message' => 'User registered successfully'];
            } else {
                return ['status' => 'error', 'message' => 'User not registered successfully' . $this->conn->error];
            }
        }
    }

?>