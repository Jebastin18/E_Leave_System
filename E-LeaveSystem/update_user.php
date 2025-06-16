<?php
require_once 'db.php';
session_start();
if (!isset($_SESSION["username"]) || $_SESSION["role"] !== "Admin") {
    http_response_code(403);
    exit("Access denied.");
}
$id = $_POST['id'];
$name = trim($_POST['name']);
$password = trim($_POST['password']);
$role = $_POST['role'];
$status = $_POST['status'];
$errors = [];
if (strlen($name) > 25) {
    $errors[] = "Name cannot exceed 25 characters.";
}
if (strlen($password) < 8) {
    $errors[] = "Password must be at least 8 characters.";
}
if (empty($errors)) {
    $stmt = $conn->prepare("UPDATE users SET name=?, password=?, role=?, status=? WHERE id=?");
    $stmt->bind_param("ssssi", $name, $password, $role, $status, $id);
    $stmt->execute();
    $stmt->close();
    echo "User updated successfully.";
} else {
    http_response_code(400);
    echo implode("\n", $errors);
}
$conn->close();
?>