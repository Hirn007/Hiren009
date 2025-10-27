<?php
$num1 = 20;
$num2 = 10;
$operator = "+"; 

if ($operator == "+") {
    $result = $num1 + $num2;
    echo "Result: " . $result;
} elseif ($operator == "-") {
    $result = $num1 - $num2;
    echo "Result: " . $result;
} elseif ($operator == "*") {
    $result = $num1 * $num2;
    echo "Result: " . $result;
} elseif ($operator == "/") {
    if ($num2 != 0) {
        $result = $num1 / $num2;
        echo "Result: " . $result;
    } else {
        echo "Error: Division by zero!";
    }
} else {
    echo "Invalid operator!";
}
?>
