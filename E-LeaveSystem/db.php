<?php
$conn = new mysqli("localhost", "root", "", "eleave_db");

// $conn = new mysqli("localhost", "tracecodeadmin_eleave_db", "V9tyQ9CC5A39nsqyTMxK", "tracecodeadmin_eleave_db");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
