<?php
require_once(__DIR__ . '/../Model/db_connection.php'); // Include the database connection
require_once 'User.php'; // Include the User class

class Admin extends User {
    public function addStation($name, $location) {
       
    }

    public function removeStation($stationId) {
       
    }

    public function deleteUserAccount($userId) {
        $stmt = $this->pdo->prepare("DELETE FROM user WHERE User_ID = :id");
        return $stmt->execute(['id' => $userId]);
    }

    public function updateTicketPrice($lineId, $newPrice) {
        
    }

    public function addLine($name, $startStationId, $endStationId, $ticketPrice) {
        
    }

    public function applyDiscount($userId, $discountType) {
        $stmt = $this->pdo->prepare("UPDATE user SET discount_type = :discount WHERE ID = :id");
        return $stmt->execute(['discount' => $discountType, 'id' => $userId]);
    }

    public function listUsers() {
        $stmt = $this->pdo->query("SELECT * FROM user");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

// Handle form submissions for admin actions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $admin = new Admin($pdo);
    if (isset($_POST['action'])) {
        if ($_POST['action'] === 'addUser') {
            $firstName = $_POST['F_name'] ?? '';
            $lastName = $_POST['L_name'] ?? '';
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            $ssn = $_POST['SSN'] ?? '';
            $points = 0;
            $user = new User($pdo);
            $result = $user->signup($ssn, $email, $points, $firstName, $lastName, $password);
            if ($result === true) {
                header('Location: ../View/admin-viewUsers.php?added=1');
                exit;
            } else {
                header('Location: ../View/admin-viewUsers.php?message=' . urlencode($result));
                exit;
            }
        } elseif ($_POST['action'] === 'deleteUser') {
            $userId = $_POST['userId'] ?? '';
            $admin->deleteUserAccount($userId);
            header('Location: ../View/admin-viewUsers.php?deleted=1');
            exit;
        } elseif ($_POST['action'] === 'applyDiscount') {
            $userId = $_POST['userId'] ?? '';
            $discountType = $_POST['discountType'] ?? '';
            $admin->applyDiscount($userId, $discountType);
            header('Location: ../View/admin-viewUsers.php?message=Discount+applied');
            exit;
        } elseif ($_POST['action'] === 'editUserSave') {
            $userId = $_POST['userId'] ?? '';
            $firstName = $_POST['F_name'] ?? '';
            $lastName = $_POST['L_name'] ?? '';
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            $ssn = $_POST['SSN'] ?? '';
            // Build update query
            $params = [
                'F_name' => $firstName,
                'L_name' => $lastName,
                'email' => $email,
                'SSN' => $ssn,
                'User_ID' => $userId
            ];
            $sql = "UPDATE user SET F_name = :F_name, L_name = :L_name, email = :email, SSN = :SSN";
            if (!empty($password)) {
                $sql .= ", Password = :password";
                $params['password'] = password_hash($password, PASSWORD_BCRYPT);
            }
            $sql .= " WHERE User_ID = :User_ID";
            $stmt = $pdo->prepare($sql);
            $stmt->execute($params);
            header('Location: ../View/admin-viewUsers.php?edited=1');
            exit;
        }
        // Add more actions as needed
    }
}
?>