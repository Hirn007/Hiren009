<?php
$choice = 2;

switch ($choice) {
    case 1:
        echo "Category: Starter<br>";
        echo "Dish: Tomato Soup";
        break;
    case 2:
        echo "Category: Main Course<br>";
        echo "Dish: Butter Chicken";
        break;
    case 3:
        echo "Category: Dessert<br>";
        echo "Dish: Ice Cream";
        break;
    default:
        echo "Invalid Selection. Please choose 1, 2, or 3.";
}
?>
