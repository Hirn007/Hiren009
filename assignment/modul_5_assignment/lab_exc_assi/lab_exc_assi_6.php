<?php
$day = date("l"); 

if ($day == "Sunday") {
    echo "Happy Sunday!";
} else {
    echo "Today is " . $day;
}
?>
