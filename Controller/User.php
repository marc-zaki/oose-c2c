<?php
require_once __DIR__ . '/../Model/db_connection.php';
// filepath: c:\wamp64\www\oose-c2c\Controller\User.php

class User {
    protected int $ID;
    private string $firstName;
    private string $lastName;
    private string $password;
    private string $email;
    private int $social_security_number;
    protected $pdo;
    public function __construct($pdo, $ID = 0, $firstName = '', $lastName = '', $password = '', $email = '', $social_security_number = 0) {
        $this->pdo = $pdo;
        $this->ID = $ID;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->password = $password;
        $this->email = $email;
        $this->social_security_number = $social_security_number;
    }

    public function login($email, $password) {
        $stmt = $this->pdo->prepare("SELECT * FROM user WHERE email = :email");
        $stmt->execute(['email' => $email]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['Password'])) {
            return true;
        }
        return false;
    }

    public function signup($socialSecurityNumber, $email, $points, $firstName, $lastName, $password, $userID = 0) {
        $stmt = $this->pdo->prepare("SELECT * FROM user WHERE SSN = :socialSecurityNumber");
        $stmt->execute(['socialSecurityNumber' => $socialSecurityNumber]);
        if ($stmt->fetch()) {
            return "SSN already exists";
        }

        $stmt = $this->pdo->prepare("SELECT * FROM user WHERE email = :email");
        $stmt->execute(['email' => $email]);
        if ($stmt->fetch()) {
            return "Email already exists";
        }

        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        $stmt = $this->pdo->prepare(
            "INSERT INTO user (SSN, email, Points, F_name, L_name, Password, User_ID) 
             VALUES (:socialSecurityNumber, :email, :points, :firstName, :lastName, :password, :userID)"
        );
        $stmt->execute([
            'socialSecurityNumber' => $socialSecurityNumber,
            'email' => $email,
            'points' => $points,
            'firstName' => $firstName,
            'lastName' => $lastName,
            'password' => $hashedPassword,
            'userID' => $userID
        ]);

        return true;
    }

    public function updateProfile($newFirstName, $newLastName, $newEmail, $newPassword = null) {
        $params = [
            'firstName' => $newFirstName,
            'lastName' => $newLastName,
            'email' => $newEmail,
            'ID' => $this->ID
        ];
        $sql = "UPDATE user SET F_name = :firstName, L_name = :lastName, email = :email";
        if ($newPassword) {
            $sql .= ", Password = :password";
            $params['password'] = password_hash($newPassword, PASSWORD_BCRYPT);
        }
        $sql .= " WHERE ID = :ID";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute($params);
    }

    public function deleteProfile() {
        $stmt = $this->pdo->prepare("DELETE FROM user WHERE ID = :ID");
        return $stmt->execute(['ID' => $this->ID]);
    }

    public function logout() {
        // If using sessions
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        session_unset();
        session_destroy();
        return true;
    }
}
