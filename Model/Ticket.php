<?php
require_once 'db_connection.php'; // Include the database connection
require_once 'User.php'; // Include the User class
require_once 'Ticket.php';
require_once 'MetroLines.php'; 
abstract class Ticket {
    protected int $ticket_ID;
    protected int $start_station;
    protected int $end_station;
    protected int $startline;
    protected int $endline;
    protected int $price;

    abstract public function createTicket($type, $ticketId, $price, $departureDate, $expireDate, $numStations = null);
    abstract public function display_ticket_details();
    abstract public function calculate_price();
    abstract public function update_ticket();
}

class Metro_Ticket extends Ticket {

     public function createTicket($type, $ticketId, $price, $departureDate, $expireDate, $numStations = null) {
        switch (strtolower($type)) {
            case 'metro':
                return new MetroTicket($ticketId, $price, $departureDate, $expireDate, $numStations);
            case 'lrt':
                return new LRTTicket($ticketId, $price, $departureDate, $expireDate);
            default:
                return new Ticket($ticketId, $price, $departureDate, $expireDate);
        }
    }
    
    public function display_ticket_details() {
         echo "Ticket ID: {$this->ticketId}\n";
        echo "Price: {$this->price}\n";
        echo "Departure Date: {$this->departureDate}\n";
        echo "Expire Date: {$this->expireDate}\n";
        echo "Category: " . ($this instanceof MetroTicket ? "Metro" : ($this instanceof LRTTicket ? "LRT" : "General")) . "\n";
    }
    public function calculate_price() {
        
    }
    public function update_ticket() {
        // Metro ticket update logic
    }
}
?>