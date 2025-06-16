<?php
require_once 'db.php';
session_start();
if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit();
}
$username = $_SESSION["username"];
$ip_address = $_SERVER['REMOTE_ADDR'];
$name = $_POST['name'];
$apply_date = $_POST['apply_date'];
$from_date = $_POST['from_date'];
$to_date = $_POST['to_date'];
$permission = $_POST['Permission'];
$reason = $_POST['reason'];
$remarks = $_POST['remarks'];
$sql = "INSERT INTO leave_requests (
            username, name, apply_date, from_date, to_date,
            permission_type, reason, remarks, system_ip, approved_status
        ) VALUES (
            ?, ?, ?, ?, ?, ?, ?, ?, ?, 0
        )";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sssssssss", $username, $name, $apply_date, $from_date, $to_date, $permission, $reason, $remarks, $ip_address);
if ($stmt->execute()) {
    echo "<script>alert('Leave request submitted!'); window.location.href='leave_request.php';</script>";
} else {
    echo "Error: " . $stmt->error;
}
?>
