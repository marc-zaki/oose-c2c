<?php
    require_once '../db_connection.php'; // Include the database connection

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
    ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Metro Transit Sign Up</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-green-50 min-h-screen flex items-center justify-center p-4">
    <div class="flex flex-col md:flex-row max-w-5xl w-full bg-white rounded-lg overflow-hidden shadow-xl">
        <div class="w-full md:w-1/2 relative">
            <img src="Images\signup mt.jpg" alt="Modern metro train at station" class="w-full h-full object-cover" />
        </div>
        
        <div class="w-full md:w-1/2 flex flex-col items-center justify-center p-8">
            <div class="mb-8 text-center">
                <div class="mx-auto h-12 w-12 mb-2">
                    <svg viewBox="0 0 100 100" class="h-full w-full">
                        <circle cx="50" cy="50" r="40" fill="#1e7a44" />
                        <path d="M50 10 C20 30, 20 70, 50 90 C80 70, 80 30, 50 10" fill="#226b44" />
                    </svg>
                </div>
                <h2 class="text-xl font-medium text-gray-800">Sign up</h2>
            </div>

            <?php if (!empty($message)): ?>
                <p class="mb-4 text-center text-sm text-red-500"> <?php echo $message; ?> </p>
            <?php endif; ?>
            
            <form class="w-full max-w-md" method="POST" action="">
                <div class="flex gap-4 mb-4">
                    <div class="w-1/2">
                        <label for="firstName" class="block text-xs text-gray-500 mb-1">First Name</label>
                        <input type="text" id="firstName" name="firstName" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-1 focus:ring-green-500">
                    </div>
                    <div class="w-1/2">
                        <label for="lastName" class="block text-xs text-gray-500 mb-1">Last Name</label>
                        <input type="text" id="lastName" name="lastName" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-1 focus:ring-green-500">
                    </div>
                </div>
                
                <div class="mb-4">
                    <label for="nationalId" class="block text-xs text-gray-500 mb-1">National ID</label>
                    <input type="text" id="nationalId" name="nationalId" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-1 focus:ring-green-500">
                </div>
                
                <div class="mb-4">
                    <label for="email" class="block text-xs text-gray-500 mb-1">E-mail</label>
                    <input type="email" id="email" name="email" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-1 focus:ring-green-500">
                    <p class="text-xs text-gray-400 mt-1">Optional</p>
                </div>
                
                <div class="mb-6">
                    <label for="password" class="block text-xs text-gray-500 mb-1">Password</label>
                    <input type="password" id="password" name="password" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-1 focus:ring-green-500">
                </div>
                
                <button type="submit" class="w-full py-2 rounded bg-gradient-to-r from-green-600 to-purple-500 text-white font-medium hover:opacity-90 transition-opacity">
                    Sign Up
                </button>
                <a href="Login.php" class="block mt-4 text-center text-green-600 hover:underline">Already got an account?</a>
                <a href="/HTML/Homepage.html">backdoor</a>
            </form>
        </div>
    </div>
</body>
</html>