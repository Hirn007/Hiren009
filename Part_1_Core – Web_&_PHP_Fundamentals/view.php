<?php include 'db.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>View Complaints - TechEdge Motors</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container" style="width: 80%;">
    <h2>Submitted Complaints</h2>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Phone</th>
                <th>Email</th>
                <th>Vehicle Details</th>
                <th>Complaint</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql = "SELECT * FROM customer_complaints ORDER BY id DESC";
            // Check if the query executes successfully
            $result = mysqli_query($conn, $sql);

            if ($result && mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . (isset($row['id']) ? htmlspecialchars($row['id']) : '') . "</td>";
                    echo "<td>" . htmlspecialchars($row['name']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['phone']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['vehicle_details']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['complaint']) . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='6'>No complaints submitted yet.</td></tr>";
            }
            ?>
        </tbody>
    </table>

    <a href="index.php" class="view-btn">Back to Form</a>
</div>

</body>
</html>
