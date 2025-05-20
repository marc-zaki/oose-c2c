<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json');
require_once __DIR__ . '/../Model/Trip.php';
require_once __DIR__ . '/../Model/db_connection.php'; // This defines $db


file_put_contents('debug_post.txt', print_r($_POST, true));


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (
        isset($_POST['starting_station']) &&
        isset($_POST['final_station']) &&
        isset($_POST['starting_line']) &&
        isset($_POST['destination_line']) &&
        isset($_POST['ticketType'])
    ) {
        $trip_ID = 0;
        $trip_date = date('Y-m-d');
        $ticketType = $_POST['ticketType'] ?? '';
        $start_station = $_POST['starting_station'] ?? '';
        $end_station = $_POST['final_station'] ?? '';
        $numStations = $_POST['numStations'] ?? null;
        $user_id = $_POST['user_id'] ?? null;

        try {
            // Pass $user_id to Trip constructor
            if ($ticketType === 'metro') {
                $trip = new Trip($trip_ID, $trip_date, $ticketType, 1, $start_station, $end_station, 1, 1, $numStations, $user_id);
            } else {
                $trip = new Trip($trip_ID, $trip_date, $ticketType, 1, $start_station, $end_station, 1, 1, null, $user_id);
            }
            // Save ticket to DB
            $ticket = $trip->get_Ticket();
            // $ticket->user_id = $user_id; // REMOVE this line (no dynamic property)
            $ticket->saveToDatabase($db);

            echo json_encode([
                'success' => true,
                'ticket_type' => get_class($ticket),
                'ticket_details' => $ticket->display_ticket_details()
            ]);
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid request.']);
    }
    exit;
}
echo json_encode(['success' => false, 'message' => 'Invalid request.']);
exit;
?>