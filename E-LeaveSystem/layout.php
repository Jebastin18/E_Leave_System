<?php
if (!isset($_SESSION)) {
    session_start();
}
if (!isset($_SESSION["role"]) || !isset($_SESSION["username"])) {
    header("Location: index.php");
    exit();
}
$role = $_SESSION["role"];
$username = $_SESSION["username"];
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $role ?> Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            margin: 0;
            padding: 0;
            padding-top: 56px; 
        }
        .sidebar {
            width: 250px;
            height: 100vh;
            background-color: #343a40;
            color: white;
            padding-top: 20px;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1000;
            transition: transform 0.3s ease-in-out;
        }
        .sidebar a {
            padding: 12px 20px;
            display: block;
            color: white;
            text-decoration: none;
        }
        .sidebar a:hover {
            background-color: #495057;
        }

        .sidebar.hide {
            transform: translateX(-100%);
        }

        .main-content {
            margin-left: 250px;
            padding: 20px;
            transition: margin-left 0.3s ease-in-out;
        }

        .main-content.full {
            margin-left: 0;
        }
        .navbar {
    box-shadow: 0 2px 4px rgba(0,0,0,.1);
}
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }
            .sidebar.show {
                transform: translateX(0);
            }
            .main-content {
                margin-left: 0;
            }
        }
        #toggle-btn{
            z-index: 1050;
        }
    </style>
</head>
<body>
<nav class="navbar navbar-dark bg-dark fixed-top" style="z-index: 1030;">
    <div class="container-fluid d-flex justify-content-between">
        <button class="btn btn-outline-light" id="toggle-btn">&#9776;</button>
        <span class="navbar-brand"><?= $role ?> Panel</span>
        <a href="logout.php" onclick="clearAuth()" class="btn btn-danger">Logout</a>
    </div>
</nav>
<div class="sidebar" id="sidebar">
    <hr class="bg-light">
    <?php if ($role === "Admin"): ?>
        <a href="admin_dashboard.php">Dashboard</a>
        <a href="usermanagement.php">Manage Staff</a>
        <a href="leave_approve.php">All Leave Requests</a>
        <a href="allleave_report.php">Leave Report</a>
    <?php elseif ($role === "Staff"): ?>
        <a href="staff_dashboard.php">Dashboard</a>
        <a href="leave_request.php">Apply Leave</a>
        <a href="leave_report.php">My Leave Status</a>
    <?php endif; ?>
</div>
<div class="main-content" id="main-content">
    <?php
        if (isset($content)) {
            echo $content;
        }
    ?>
</div>
<script>
    const toggleBtn = document.getElementById("toggle-btn");
    const sidebar = document.getElementById("sidebar");
    const mainContent = document.getElementById("main-content");
    toggleBtn.addEventListener("click", () => {
        sidebar.classList.toggle("show");  // for mobile
        sidebar.classList.toggle("hide");  // for desktop
        mainContent.classList.toggle("full");
    });
    function clearAuth() {
    localStorage.removeItem('adminAuth');
    sessionStorage.clear();
}
</script>
</body>
</html>
