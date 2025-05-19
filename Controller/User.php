<?php
require_once 'db_connection.php'; // Include the database connection

class User {
    private int $ID;
    private string $firstName;
    private string $lastName;
    private string $password;
    private string $email;
    private int $social_security_number;
    private $pdo;

    public function __construct($pdo, $ID = null, $firstName = '', $lastName = '', $password = '', $email = '', $social_security_number = 0) {
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

    public function signup($firstName, $lastName, $email, $password, $socialSecurityNumber, $points = 0) {
        
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

        // CRUD
        $stmt = $this->pdo->prepare("INSERT INTO user (F_name, L_name, email, Password, SSN, Points) VALUES (:firstName, :lastName, :email, :password, :socialSecurityNumber, :points)");
        $stmt->execute([
            'firstName' => $firstName,
            'lastName' => $lastName,
            'email' => $email,
            'password' => $hashedPassword,
            'socialSecurityNumber' => $socialSecurityNumber,
            'points' => $points
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
