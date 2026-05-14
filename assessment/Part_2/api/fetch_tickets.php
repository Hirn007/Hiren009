<?php
require_once '../auth.php'; // Ensure user is logged in
require_once '../Ticket.php';

header('Content-Type: application/json');

$statusFilter = isset($_GET['status']) ? $_GET['status'] : 'All';
$tickets = Ticket::getAllTickets('../data/tickets.json');

if ($statusFilter !== 'All') {
    $filteredTickets = array_filter($tickets, function($ticket) use ($statusFilter) {
        return strcasecmp($ticket['status'], $statusFilter) === 0;
    });
    // Re-index array
    $tickets = array_values($filteredTickets);
}

// Sort by date descending (newest first)
usort($tickets, function($a, $b) {
    return strtotime($b['date']) - strtotime($a['date']);
});

echo json_encode(['success' => true, 'data' => $tickets]);
?>
