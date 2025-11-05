<!DOCTYPE html>
<html>
<head>
    <title>User Form</title>
</head>
<body>

<!-- HTML Form -->
<form method="POST" action="">
    <label for="name">Name:</label>
    <input type="text" name="name" required><br><br>

    <label for="email">Email:</label>
    <input type="email" name="email" required><br><br>

    <input type="submit" value="Submit">
</form>

<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];

   
    echo "<h3>Entered Details:</h3>";
    echo "Name: " . $name . "<br>";
    echo "Email: " . $email;
}
?>

</body>
</html>
