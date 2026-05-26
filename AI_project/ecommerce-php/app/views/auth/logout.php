<?php
session_start();

// sabhi session values hatana
session_unset();

// pura session destroy karna
session_destroy();

// login page par redirect
header("Location: index.php?page=login");
exit;