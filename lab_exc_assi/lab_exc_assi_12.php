<!DOCTYPE html>
<html>
<head>
    <title>Chessboard</title>
    <style>
        .black { background-color: black; width: 40px; height: 40px; }
        .white { background-color: white; width: 40px; height: 40px; }
        table { border-collapse: collapse; }
        td { border: 1px solid #000; }
    </style>
</head>
<body>

<table>
<?php
for ($row = 1; $row <= 8; $row++) {
    echo "<tr>";
    for ($col = 1; $col <= 8; $col++) {
        if (($row + $col) % 2 == 0) {
            echo "<td class='white'></td>";
        } else {
            echo "<td class='black'></td>";
        }
    }
    echo "</tr>";
}
?>
</table>

</body>
</html>
