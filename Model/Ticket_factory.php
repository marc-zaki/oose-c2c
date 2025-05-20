<?php
require_once 'Metro_Ticket.php';
require_once 'LRT_Ticket.php';

class Ticket_Factory {
    public static function createTicket($type, ...$params) {
        switch (strtolower($type)) {
            case 'metro':
                return new Metro_Ticket(...$params);
            case 'lrt':
                return new LRT_Ticket(...$params);
            default:
                throw new Exception("Unknown ticket type: $type");
        }
    }
}
?>