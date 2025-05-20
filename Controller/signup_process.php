<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json');

require_once __DIR__ . '/User.php';
require_once __DIR__ . '/../Model/db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $firstName = $_POST['firstName'] ?? '';
    $lastName = $_POST['lastName'] ?? '';
    $nationalId = $_POST['nationalId'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $points = 0; // Default points

    $user = new User($pdo);
    $result = $user->signup($nationalId, $email, $points, $firstName, $lastName, $password);

    if ($result === true) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => $result]);
    }
    exit;
}

echo json_encode(['success' => false, 'message' => 'Invalid request.']);
exit;
?>