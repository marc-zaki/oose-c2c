<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json');
require_once __DIR__ . '/../Model/Trip.php';
require_once __DIR__ . '/../Model/db_connection.php'; // This defines $db

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $trip_ID = 0;
    $trip_date = date('Y-m-d');
    $ticketType = $_POST['ticketType'] ?? '';
    $start_station = $_POST['starting_station'] ?? '';
    $end_station = $_POST['final_station'] ?? '';
    $numStations = $_POST['numStations'] ?? null;

    try {
        if ($ticketType === 'metro') {
            $trip = new Trip($trip_ID, $trip_date, $ticketType, 1, $start_station, $end_station, 1, 1, $numStations);
        } else {
            $trip = new Trip($trip_ID, $trip_date, $ticketType, 1, $start_station, $end_station, 1, 1);
        }
        // Save ticket to DB
        $ticket = $trip->get_Ticket();
        $ticket->saveToDatabase($db);

        echo json_encode([
            'success' => true,
            'ticket_type' => get_class($ticket),
            'ticket_details' => $ticket->display_ticket_details()
        ]);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
    exit;
}
echo json_encode(['success' => false, 'message' => 'Invalid request.']);
exit;
?>