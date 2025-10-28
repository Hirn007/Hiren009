<?php
include_once('lab_exc_assi_2.html');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars(trim($_POST["name"]));
    $email = htmlspecialchars(trim($_POST["email"]));
    $message = htmlspecialchars(trim($_POST["message"]));

    $errors = [];

    if (empty($name)) {
        $errors[] = "Name is required.";
    }

    if (empty($email)) {
        $errors[] = "Email is required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format.";
    }

    if (empty($message)) {
        $errors[] = "Message cannot be empty.";
    }

    if (empty($errors)) {
        echo "<h2>Form Submitted Successfully!</h2>";
        echo "<p><strong>Name:</strong> $name</p>";
        echo "<p><strong>Email:</strong> $email</p>";
        echo "<p><strong>Message:</strong> $message</p>";
    } else {
        echo "<h2>There were some errors:</h2><ul>";
        foreach ($errors as $error) {
            echo "<li style='color:red;'>$error</li>";
        }
        echo "</ul><a href='form.html'>Go Back</a>";
    }
} else {
    echo "<p>Please submit the form first.</p>";
}
?>
