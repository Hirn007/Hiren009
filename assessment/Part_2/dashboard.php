<?php
require_once 'auth.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - AutoFix HelpDesk</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="dashboard-body">
    <nav class="navbar">
        <div class="nav-brand">AutoFix HelpDesk</div>
        <div class="nav-user">
            <span>Welcome, <strong><?php echo htmlspecialchars($_SESSION['username']); ?></strong></span>
            <a href="logout.php" class="btn btn-logout">Logout</a>
        </div>
    </nav>

    <div class="container main-content">
        <!-- Ticket Submission Form -->
        <section class="card form-section">
            <h2 class="section-title">Create New Ticket</h2>
            <form id="ticketForm">
                <div class="form-row">
                    <div class="form-group half-width">
                        <label for="title">Ticket Title</label>
                        <input type="text" id="title" name="title" placeholder="E.g., System Crash" required>
                    </div>
                    <div class="form-group half-width">
                        <label for="assignedTo">Assign To</label>
                        <input type="text" id="assignedTo" name="assignedTo" placeholder="E.g., IT Support" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="status">Initial Status</label>
                    <select id="status" name="status">
                        <option value="Open">Open</option>
                        <option value="Closed">Closed</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary" id="submitBtn">Submit Ticket</button>
                <div id="formMessage" class="hidden alert"></div>
            </form>
        </section>

        <!-- Ticket Display Area -->
        <section class="card display-section">
            <div class="display-header">
                <h2 class="section-title">Ticket List</h2>
                <div class="filter-group">
                    <button class="filter-btn active" data-filter="All">All</button>
                    <button class="filter-btn" data-filter="Open">Open</button>
                    <button class="filter-btn" data-filter="Closed">Closed</button>
                </div>
            </div>
            
            <div class="table-responsive">
                <table class="ticket-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Title</th>
                            <th>Status</th>
                            <th>Assigned To</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody id="ticketTableBody">
                        <!-- Tickets will be loaded here via AJAX -->
                    </tbody>
                </table>
            </div>
        </section>
    </div>

    <script src="assets/js/script.js"></script>
</body>
</html>
