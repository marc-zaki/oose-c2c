<?php
require_once 'db_connection.php'; // Include the database connection
require_once 'User.php'; // Include the User class
require_once 'Ticket.php';
require_once 'metrolines.php';
class Metro_Ticket extends Ticket {
    protected int $numStations;

    public function generate_ticket() {
        // Metro ticket generation logic
    }
    public function display_ticket_details() {
        // Metro ticket details logic
    }
    public function calculate_price() {
        if ($this->numStations <= 9) {
            return 8;
        } elseif ($this->numStations <= 16&& $this->numStations > 9) {
            return 10;
        } elseif ($this->numStations <= 23&& $this->numStations > 16) {
            return 15;
        } elseif ($this->numStations <= 39&& $this->numStations > 23) {
            return 20;
        } 
    }
    public function update_ticket() {
        // Metro ticket update logic
    }
}
?>