<?php
$numbers = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10];
$even = 0;
$odd = 0;

foreach ($numbers as $num) {
    if ($num % 2 == 0) {
        $even++;
    } else {
        $odd++;
    }
}

echo "Even numbers: " . $even . "<br>";
echo "Odd numbers: " . $odd;
?>
