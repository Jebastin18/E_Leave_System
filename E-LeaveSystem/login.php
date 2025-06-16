<?php
session_start();
require_once 'db.php';
$success = "";
$error = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];
    $role     = $_POST["role"];
    $sql = "SELECT * FROM users WHERE username=? AND role=? AND status='Active'";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $username, $role);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        if ($password === $user['password']) {
            $_SESSION["username"] = $user["username"];
            $_SESSION["role"] = $user["role"];
            if ($role === "Admin") {
                header("Location: admin_dashboard.php");
            } else {
                header("Location: staff_dashboard.php");
            }
            exit();
        } else {
            $_SESSION["error"] = "Incorrect password.";
        }
    } else {
        $_SESSION["error"] = "Invalid username, role, or account is inactive.";
    }
    $stmt->close();
    $conn->close();
    header("Location: index.php");
    exit();
}
?>