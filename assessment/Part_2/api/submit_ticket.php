<?php
require_once '../auth.php'; // Ensure user is logged in
require_once '../Ticket.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $assignedTo = trim($_POST['assignedTo'] ?? '');
    $status = trim($_POST['status'] ?? 'Open');

    if (empty($title) || empty($assignedTo)) {
        echo json_encode(['success' => false, 'message' => 'Title and Assigned To are required.']);
        exit;
    }

    // Create and save new ticket
    $ticket = new Ticket($title, $status, $assignedTo);
    $ticket->save('../data/tickets.json');

    echo json_encode(['success' => true, 'message' => 'Ticket created successfully!']);
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}
?>
