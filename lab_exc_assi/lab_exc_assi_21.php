<?php
function reverseString($str) {
    $reversed = "";
    $length = strlen($str);
    for ($i = $length - 1; $i >= 0; $i--) {
        $reversed .= $str[$i];
    }
    return $reversed;
}

// Example:
echo "Reversed String: " . reverseString("Hello");
?>
