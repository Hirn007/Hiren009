<?php

$status = $_GET['status'];

$file = "tickets.json";

if(file_exists($file)) {

    $tickets = json_decode(file_get_contents($file), true);

    echo "<table>";

    echo "<tr>
            <th>ID</th>
            <th>Title</th>
            <th>Status</th>
            <th>Assigned To</th>
            <th>Date</th>
          </tr>";

    foreach($tickets as $ticket) {

        if($ticket['status'] == $status) {

            echo "<tr>";

            echo "<td>".$ticket['id']."</td>";
            echo "<td>".$ticket['title']."</td>";
            echo "<td>".$ticket['status']."</td>";
            echo "<td>".$ticket['assigned_to']."</td>";
            echo "<td>".$ticket['date']."</td>";

            echo "</tr>";
        }
    }

    echo "</table>";

} else {

    echo "No Tickets Found";
}

?>