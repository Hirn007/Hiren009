<?php
function calculator($num1, $num2, $operator) {
    if ($operator == "+") {
        return $num1 + $num2;
    } elseif ($operator == "-") {
        return $num1 - $num2;
    } elseif ($operator == "*") {
        return $num1 * $num2;
    } elseif ($operator == "/") {
        return $num2 != 0 ? $num1 / $num2 : "Error: Division by zero";
    } else {
        return "Invalid operator";
    }
}

// Example:
echo "Result: " . calculator(10, 5, "+");
?>
