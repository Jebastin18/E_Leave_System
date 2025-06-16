<?php
require_once 'db.php';
session_start();
if ($_SESSION["role"] !== "Staff") {
     header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Staff Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            margin: 0;
            padding: 0;
        }
        .content {
            margin-left: 250px;
            padding: 20px;
            transition: margin-left 0.3s ease;
            background-color: #f8f9fa;
        }
        @media (max-width: 768px) {
            .content {
                margin-left: 0;
            }
            .sidebar.show + .content {
                margin-left: 250px;
            }
        }
    </style>
</head>
<body>
<?php include 'layout.php'; ?>
<div class="content" id="main-content">
    <h2>Welcome, <?= htmlspecialchars($_SESSION["username"]) ?></h2>
    <p>This is your dashboard.</p>
</div>
</body>
</html>
