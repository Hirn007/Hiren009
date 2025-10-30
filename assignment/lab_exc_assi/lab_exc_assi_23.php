<?php
$string1 = "Hello";
$string2 = "World!";

$concatenatedString = $string1 . " " . $string2;
echo "Concatenated String: " . $concatenatedString . "<br>";

$substring = substr($concatenatedString, 0, 5);  
echo "Substring (0 to 5): " . $substring . "<br>";

$length = strlen($concatenatedString);
echo "Length of String: " . $length . "<br>";

echo "Uppercase: " . strtoupper($concatenatedString) . "<br>";

echo "Lowercase: " . strtolower($concatenatedString) . "<br>";
?>
