<?php
session_start();

if(!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

include 'Ticket.php';

if($_SERVER['REQUEST_METHOD'] == 'POST') {

    $title = $_POST['title'];
    $assigned_to = $_POST['assigned_to'];

    $ticket = new Ticket(
        rand(1000,9999),
        $title,
        "Open",
        $assigned_to,
        date("Y-m-d H:i:s")
    );

    $file = "tickets.json";

    if(file_exists($file)) {
        $data = json_decode(file_get_contents($file), true);
    } else {
        $data = [];
    }

    $data[] = $ticket->toArray();

    file_put_contents($file, json_encode($data, JSON_PRETTY_PRINT));

    $success = "Ticket Created Successfully";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">

    <h2>Welcome <?php echo $_SESSION['user']; ?></h2>

    <a href="logout.php" class="logout-btn">Logout</a>

    <h3>Create Ticket</h3>

    <?php
    if(isset($success)) {
        echo "<p class='success'>$success</p>";
    }
    ?>

    <form method="POST" onsubmit="return validateForm()">

        <input type="text" id="title" name="title" placeholder="Ticket Title">

        <input type="text" id="assigned_to" name="assigned_to" placeholder="Assigned To">

        <button type="submit">Create Ticket</button>

    </form>

    <p id="error-msg"></p>

    <hr>

    <button onclick="loadTickets('Open')">Open Tickets</button>

    <button onclick="loadTickets('Closed')">Closed Tickets</button>

    <div id="ticket-data"></div>

</div>

<script src="script.js"></script>

</body>
</html>