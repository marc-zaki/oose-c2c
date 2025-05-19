<?php
require_once 'db_connection.php'; // Include the database connection
require_once 'User.php'; // Include the User class
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
        $stmt = $this->pdo->prepare("SELECT * FROM trip_history WHERE user_id = :user_id ORDER BY trip_date DESC");
        $stmt->execute(['user_id' => $this->ID]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>