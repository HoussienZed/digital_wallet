<?php

    include("../connection/connection.php");

    class user {
        public static function create_user ($fullName, $password, $repeatedPassword, $email, $phoneNumber, $address, $profilePicture) {

            if($password !== $repeatedPassword) {
                return ['status' => 'error', 'message' => 'Passwords do not match'];
            }

            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            
            $uploadDir = "uploads/";
            $deafultImage =  "../wallet_client/assets/illustration-businessman_53876-5856.avif";

            $profilePicturePath = $deafultImage;

            if($profilePicture && $profilePicture['error'] === UPLOAD_ERR_OK) {
                $fileName = uniqid() . '_' . basename($profilePicture['name']); // to generate a unique name 
                $profilePicturePath = $uploadDir . $fileName;
                
                //if(!move_uploaded_file($profilePicture['tmp_name'], $profilePicturePath)) {
                    //return ['status' => 'error', 'message' => 'Failed to upload profile pictaure'];
                //}
            }

            $query ="INSERT INTO users (full_name, email, password, phone_number, address, profile_picture) VALUE (?, ?, ?, ?, ?, ?)";
            $query -> bind_param("ssssss", $fullName, $email. $hashedPassword, $phoneNumber, $address, $profilePicturePath);
            $query -> execute();
        }
    }

?>