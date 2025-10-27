<?php
$array = [1, 0, 5, 0, 7, 9, 0, 3];
$nonZero = [];
$zero = [];

// Separate zero and non-zero values
foreach ($array as $value) {
    if ($value == 0) {
        $zero[] = $value;
    } else {
        $nonZero[] = $value;
    }
}

// Combine non-zero values first, then zeros
$result = array_merge($nonZero, $zero);

echo "Original Array: ";
print_r($array);
echo "<br>Modified Array (Zeros at bottom): ";
print_r($result);
?>
