<?php
require_once 'db_connection.php'; // Include the database connection
require_once 'User.php'; // Include the User class
require_once 'Ticket.php';

abstract class Ticket {
    protected int $ticket_ID;
    protected int $start_station;
    protected int $end_station;
    protected int $startline;
    protected int $endline;
    protected int $price;

    abstract public function generate_ticket();
    abstract public function display_ticket_details();
    abstract public function calculate_price();
    abstract public function update_ticket();
}

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