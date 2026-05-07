<?php
include_once('model.php');
$m = new model();
$sql = "ALTER TABLE contact ADD COLUMN phone VARCHAR(20) AFTER email";
if ($m->conn->query($sql)) {
    echo "Column 'phone' added successfully.";
} else {
    echo "Error adding column: " . $m->conn->error;
}
?>
