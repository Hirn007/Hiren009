<?php
include_once('model.php');
$m = new model();

// Simulate data
$_REQUEST['name'] = "Test User";
$_REQUEST['email'] = "test@example.com";
$_REQUEST['phone'] = "1234567890";
$_REQUEST['subject'] = "Test Subject";
$_REQUEST['message'] = "Test Message";

// Include Controller logic parts manually since we want to test that specific case
// Or just run a query to check if it's working now
$name=$_REQUEST['name'];
$email=$_REQUEST['email'];
$phone=$_REQUEST['phone'];
$subject=$_REQUEST['subject'];
$message=$_REQUEST['message'];

$arr=array("name"=>$name, "email"=>$email, "phone"=>$phone, "subject"=>$subject, "message"=>$message);
$run = $m->insert('contact', $arr);

if ($run) {
    echo "Insertion successful!\n";
    $res = $m->conn->query("SELECT * FROM contact WHERE email='test@example.com' ORDER BY id DESC LIMIT 1");
    $row = $res->fetch_assoc();
    print_r($row);
} else {
    echo "Insertion failed: " . $m->conn->error;
}
?>
