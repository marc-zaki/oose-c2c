<?php
require_once 'db_connection.php'; // Include the database connection
require_once 'User.php'; // Include the User class
require_once 'Ticket.php';
//require_once 'metrolines.php';
class Metro_Ticket extends Ticket {
    protected int $numStations;

    public function __construct($ticket_ID, $start_station, $end_station, $startline, $endline, $numStations) {
        $this->ticket_ID = $ticket_ID;
        $this->start_station = $start_station;
        $this->end_station = $end_station;
        $this->startline = $startline;
        $this->endline = $endline;
        $this->numStations = 0;
        $this->price = $this->calculate_price();
    }

    public function generate_ticket() {
        // Metro ticket generation logic
    }
    public function display_ticket_details() {
        return "Metro Ticket: ID {$this->ticket_ID}, From {$this->start_station} to {$this->end_station}, Price: {$this->price}";
    }
    public function calculate_price() {
        if ($this->numStations <= 9) {
            return 8;
        } elseif ($this->numStations <= 16) {
            return 10;
        } elseif ($this->numStations <= 23) {
            return 15;
        } elseif ($this->numStations <= 39) {
            return 20;
        }
        return 0;
    }
    public function update_ticket() {
        // Metro ticket update logic
    }
    public function saveToDatabase($db) {
        $type = 'metro';
        $stmt = $db->prepare("INSERT INTO Ticket (price, Type, start_station, end_station, startline, endline) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("isssss", $this->price, $type, $this->start_station, $this->end_station, $this->startline, $this->endline);
        $stmt->execute();
        $stmt->close();
    }
}
?>