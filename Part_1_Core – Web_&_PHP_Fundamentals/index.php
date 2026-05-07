<!DOCTYPE html>
<html>
<head>
    <title>TechEdge Motors</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">
    <h2>TechEdge Motors - Customer Complaint Form</h2>

    <form action="submit.php" method="POST">

        <label>Full Name</label>
        <input type="text" name="name" required>

        <label>Phone Number</label>
        <input type="text" name="phone" required>

        <label>Email Address</label>
        <input type="email" name="email" required>

        <label>Vehicle Details</label>
        <input type="text" name="vehicle_details" required>

        <label>Complaint</label>
        <textarea name="complaint" rows="5" required></textarea>

        <button type="submit">Submit Complaint</button>

    </form>

    <a href="view.php" class="view-btn">View Submissions</a>
</div>

</body>
</html>