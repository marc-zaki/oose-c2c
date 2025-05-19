<?php
require_once 'db_connection.php'; 
require_once 'User.php'; 
require_once 'Ticket_Factory.php';

class Trip {
    private int $trip_ID;
    private string $trip_date;
    private Ticket $ticket;

    public function __construct(int $trip_ID, string $trip_date, string $ticketType, ...$ticketParams) {
        $this->trip_ID = $trip_ID;
        $this->trip_date = $trip_date;
        // Create the ticket using the factory
        $this->ticket = Ticket_Factory::createTicket($ticketType, ...$ticketParams);
    }

    public function startTrip() {
        // Logic to start the trip
    }

    public function get_Ticket(): Ticket {
        return $this->ticket;
    }

    public function validate_Ticket() {
        // Logic to validate the ticket
    }

    public function bookTrip() {
        // Logic to book the trip
    }

    public function cancelTrip() {
        // Logic to cancel the trip
    }

    public function display_Trip() {
        // Logic to display trip details
        echo "Trip ID: {$this->trip_ID}, Date: {$this->trip_date}\n";
        $this->ticket->display_ticket_details();
    }

    public function refund_Trip() {
        // Logic to refund the trip
    }
}
?>