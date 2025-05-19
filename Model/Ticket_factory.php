<?php
require_once 'db_connection.php'; // Include the database connection
require_once 'LRT_Ticket.php';
require_once 'Metro_Ticket.php';

class Ticket_Factory {
    public static function createTicket($type, ...$params) {
        if ($type === 'LRT') {
            return new LRT_Ticket(...$params);
        } elseif ($type === 'Metro') {
            return new Metro_Ticket(...$params);
        }
        throw new Exception("Unknown ticket type");
    }
}
?>