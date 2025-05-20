<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

header('Content-Type: application/json');

require_once __DIR__ . '/User.php';
require_once __DIR__ . '/../Model/db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    // Check for admin credentials
    if ($email === 'admin@oose.c2c.com' && $password === 'root') {
        $_SESSION['user_id'] = 'admin';
        echo json_encode(['success' => true, 'role' => 'admin']);
        exit;
    }

    // Normal user login
    $user = new User($pdo);
    if ($user->login($email, $password)) {
        echo json_encode(['success' => true, 'role' => 'user']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid email or password.']);
    }
    exit;
}

echo json_encode(['success' => false, 'message' => 'Invalid request.']);
exit;
?>