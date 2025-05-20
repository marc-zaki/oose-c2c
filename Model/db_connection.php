<?php
// Database connection details
$host = 'localhost';
$dbname = 'oose';
$username = 'root';
$password = '';

try {
    // Create a new PDO instance
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    // Set error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo "Database connection successful."; // REMOVE or COMMENT OUT this line
} catch (PDOException $e) {
    // Handle connection error
    die("Database connection failed: " . $e->getMessage());
}

$db = new mysqli('localhost', 'root', '', 'oose');
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}
?>