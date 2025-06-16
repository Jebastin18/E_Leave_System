<?php
 require_once 'db.php';
session_start();
if ($_SESSION["role"] !== "Admin") {
    header("Location: admin_approved.php");
    exit();
}
echo "<h2>Welcome Admin: " . $_SESSION["username"] . "</h2>";
?>
