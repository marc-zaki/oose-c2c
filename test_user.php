<?php
<?php
require_once 'db_connection.php';
require_once 'User.php';

// Create a User object
$user = new User($pdo);

// Test signup
$result = $user->signup('Omar', 'Badr', 'omar@example.com', 'mypassword', 123456789, 0);
if ($result === true) {
    echo "Signup successful!\n";
} else {
    echo "Signup failed: $result\n";
}

// Test login
if ($user->login('omar@example.com', 'mypassword')) {
    echo "Login successful!\n";
} else {
    echo "Login failed!\n";
}