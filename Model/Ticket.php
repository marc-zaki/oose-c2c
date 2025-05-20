<?php
require_once 'db_connection.php';
require_once 'MetroLines.php';

abstract class Ticket {
    protected int $ticket_ID;
    protected string $start_station;
    protected string $end_station;
    protected string $startline;
    protected string $endline;
    protected int $price;

    abstract public function generate_ticket();
    abstract public function display_ticket_details();
    abstract public function calculate_price();
    abstract public function update_ticket();
    abstract public function saveToDatabase($db);
}
?>