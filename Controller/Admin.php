<?php
require_once 'db_connection.php'; // Include the database connection
require_once 'User.php'; // Include the User class

class Admin extends User {
    public function addStation($name, $location) {
       
    }

    public function removeStation($stationId) {
       
    }

    public function deleteUserAccount($userId) {
        $stmt = $this->pdo->prepare("DELETE FROM user WHERE ID = :id");
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
}
?>