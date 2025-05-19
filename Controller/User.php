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

    public function updateProfile() {
        // Implement profile update logic
    }

    public function deleteProfile() {
        // Implement profile deletion logic
    }

    public function logout() {
        // Implement logout logic
    }
}

class Admin extends User {
    public function addStation() {
        // Implement add station logic
    }

    public function removeStation() {
        // Implement remove station logic
    }

    public function deleteUserAccount() {
        // Implement delete user account logic
    }

    public function updateTicketPrice() {
        // Implement update ticket price logic
    }

    public function addLine() {
        // Implement add line logic
    }

    public function applyDiscount() {
        // Implement apply discount logic
    }
}

class Customer extends User {
    protected string $discountType;
    protected int $numberofPoints;
    protected bool $mwasalatCard;

    public function __construct($pdo, $ID = null, $firstName = '', $lastName = '', $password = '', $email = '', $social_security_number = 0, $discountType = '', $numberofPoints = 0, $mwasalatCard = false) {
        parent::__construct($pdo, $ID, $firstName, $lastName, $password, $email, $social_security_number);
        $this->discountType = $discountType;
        $this->numberofPoints = $numberofPoints;
        $this->mwasalatCard = $mwasalatCard;
    }

    public function viewTripHistory() {
        // Implement view trip history logic
    }
}