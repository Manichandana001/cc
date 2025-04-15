<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: index.html");
    exit();
}
echo "<h1>Welcome to the Portal, " . $_SESSION['user'] . "!</h1>";
?>