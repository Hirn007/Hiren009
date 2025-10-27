<?php
// Display default date and time
echo "Current Date & Time (default): " . date("Y-m-d H:i:s") . "<br><br>";

echo "1. Day-Month-Year: " . date("d-m-Y") . "<br>";
echo "2. Month-Day-Year: " . date("m-d-Y") . "<br>";
echo "3. Year/Month/Day: " . date("Y/m/d") . "<br>";
echo "4. Full Date (Text Format): " . date("l, F j, Y") . "<br>";
echo "5. Short Date: " . date("d M Y") . "<br><br>";

echo "6. 24-hour format: " . date("H:i:s") . "<br>";
echo "7. 12-hour format: " . date("h:i:s A") . "<br>";
echo "8. Hour:Minute AM/PM: " . date("h:i A") . "<br><br>";

echo "9. Full Date & Time: " . date("l, d F Y h:i:s A") . "<br>";
echo "10. RFC 822 Format: " . date("r") . "<br>";
echo "11. ISO 8601 Format: " . date("c") . "<br>";
?>
