<?php
require_once 'db_connection.php'; // Include the database connection

class User {
    protected int $ID;
    protected string $firstName;
    protected string $lastName;
    protected string $password;
    protected string $email;
    protected int $social_security_number;

    public function __construct($ID, $firstName, $lastName, $password, $email, $social_security_number) {
        $this->ID = $ID;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->password = $password;
        $this->email = $email;
        $this->social_security_number = $social_security_number;
    }

    public function login() {
      

    class User {
        private $pdo; // Database connection instance

        public function __construct($pdo) {
            $this->pdo = $pdo;
        }

        public function login($email, $password) {
            // Login logic using database
            $stmt = $this->pdo->prepare("SELECT * FROM user WHERE email = :email");
            $stmt->execute(['email' => $email]);
            $user = $stmt->fetch();

            if ($user && password_verify($password, $user['Password'])) {
                return true;
            }

            return false;
        }
    }

    // Handle form submission
    $message = "";
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        $user = new User($pdo);
        $loginResult = $user->login($email, $password);

        if ($loginResult) {
            header("Location: Homepage.html");
            exit();
        } else {
            $message = "Login failed: Invalid email or password.";
        }
    }


    }

    public function signup() {

    class User{
        private $firstName;
        private $lastName;
        private $password;
        private $email;
        private $socialSecurityNumber;
        private $points;
        private $userId;
        private $pdo; // Database connection instance

        public function __construct($pdo) {
            $this->pdo = $pdo;
        }

        public function login($email, $password){
            // Login logic using database
            $stmt = $this->pdo->prepare("SELECT * FROM user WHERE F_name = :email");
            $stmt->execute(['email' => $email]);
            $user = $stmt->fetch();

            if ($user && password_verify($password, $user['Password'])) {
                return true;
            }

            return false;
        }

        public function signup($firstName, $lastName, $email, $password, $socialSecurityNumber, $points = 0) {
            // Check if SSN already exists
            $stmt = $this->pdo->prepare("SELECT * FROM user WHERE SSN = :socialSecurityNumber");
            $stmt->execute(['socialSecurityNumber' => $socialSecurityNumber]);
            if ($stmt->fetch()) {
                return "SSN already exists"; // SSN already exists
            }

            // Check if email already exists
            $stmt = $this->pdo->prepare("SELECT * FROM user WHERE email = :email");
            $stmt->execute(['email' => $email]);
            if ($stmt->fetch()) {
                return "Email already exists"; // Email already exists
            }

            // Hash the password
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

            // Insert new user into the database
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

        public function updateProfile(){
            //code
        }

        public function deleteprofile(){
            //code
        }

        public function logout(){
            //code
        }

        public function viewTripHistory(){
            //code
        }
    }

    // Handle form submission
    $message = "";
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $firstName = $_POST['firstName'] ?? '';
        $lastName = $_POST['lastName'] ?? '';
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        $socialSecurityNumber = $_POST['nationalId'] ?? '';

        $user = new User($pdo);
        $signupResult = $user->signup($firstName, $lastName, $email, $password, $socialSecurityNumber);

        if ($signupResult === true) {
            header("Location: Login.php");
            exit();
        } else {
            $message = "Signup failed: " . $signupResult;
        }
    }

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

    public function __construct($ID, $firstName, $lastName, $password, $email, $social_security_number, $discountType, $numberofPoints, $mwasalatCard) {
        parent::__construct($ID, $firstName, $lastName, $password, $email, $social_security_number);
        $this->discountType = $discountType;
        $this->numberofPoints = $numberofPoints;
        $this->mwasalatCard = $mwasalatCard;
    }

    public function viewTripHistory() {
        // Implement view trip history logic
    }
}