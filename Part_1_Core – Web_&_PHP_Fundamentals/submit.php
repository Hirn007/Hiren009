<?php

include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = trim($_POST['name']);
    $phone = trim($_POST['phone']);
    $email = trim($_POST['email']);
    $vehicle = trim($_POST['vehicle_details']);
    $complaint = trim($_POST['complaint']);

    // Validation
    if (empty($name) || empty($phone) || empty($email) || empty($vehicle) || empty($complaint)) {
        die("All fields are required.");
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Invalid Email Format");
    }

    // Insert Query
    $sql = "INSERT INTO customer_complaints(name, phone, email, vehicle_details, complaint)
            VALUES('$name', '$phone', '$email', '$vehicle', '$complaint')";

    if (mysqli_query($conn, $sql)) {
        echo "
        <script>
            alert('Complaint Submitted Successfully');
            window.location.href='index.php';
        </script>
        ";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

?>