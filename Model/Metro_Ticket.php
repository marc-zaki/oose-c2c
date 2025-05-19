<?php
require_once 'db_connection.php'; // Include the database connection
require_once 'User.php'; // Include the User class
require_once 'Ticket.php';

class Metro_Ticket extends Ticket {
    public function generate_ticket() {
        // Metro ticket generation logic
    }
    public function display_ticket_details() {
        // Metro ticket details logic
    }
    public function calculate_price() {
        // Metro price calculation logic
    }
    public function update_ticket() {
        // Metro ticket update logic
    }
}
?>