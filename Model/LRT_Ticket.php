<?php
require_once 'db_connection.php'; // Include the database connection
require_once 'User.php'; // Include the User class
require_once 'Ticket.php';

class LRT_Ticket extends Ticket {
    public function __construct($ticket_ID, $start_station, $end_station, $startline, $endline) {
        $this->ticket_ID = $ticket_ID;
        $this->start_station = $start_station;
        $this->end_station = $end_station;
        $this->startline = $startline;
        $this->endline = $endline;
        $this->price = $this->calculate_price();
    }

    public function generate_ticket() {
        // LRT ticket generation logic
    }
    public function display_ticket_details() {
        return "LRT Ticket: ID {$this->ticket_ID}, From {$this->start_station} to {$this->end_station}, Price: {$this->price}";
    }
    public function calculate_price() {
        // LRT price calculation logic
        return 15; // Example static price
    }
    public function update_ticket() {
        // LRT ticket update logic
    }
    public function saveToDatabase($db) {
        $stmt = $db->prepare("INSERT INTO Ticket (price, Type, start_station, end_station, startline, endline) VALUES (?, ?, ?, ?, ?, ?)");
        $type = 'lrt';
        $stmt->bind_param("isssss", $this->price, $type, $this->start_station, $this->end_station, $this->startline, $this->endline);
        $stmt->execute();
        $stmt->close();
    }
}
?>