<?php
require_once 'db.php';
session_start();
if (!isset($_SESSION["role"]) || $_SESSION["role"] !== "Admin") {
    header("Location: index.php");
    exit();
}
$staffResult = $conn->query("SELECT COUNT(*) AS total_staff FROM users WHERE role='Staff'");
$staffCount = $staffResult->fetch_assoc()['total_staff'] ?? 0;
$pendingResult = $conn->query("SELECT COUNT(*) AS pending FROM leave_requests WHERE approved_status = 0");
$pendingCount = $pendingResult->fetch_assoc()['pending'] ?? 0;
$approvedResult = $conn->query("SELECT COUNT(*) AS approved FROM leave_requests WHERE approved_status = 1");
$approvedCount = $approvedResult->fetch_assoc()['approved'] ?? 0;
$rejectedResult = $conn->query("SELECT COUNT(*) AS rejected FROM leave_requests WHERE approved_status = 2");
$rejectedCount = $rejectedResult->fetch_assoc()['rejected'] ?? 0;
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard | e-Leave System</title>
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
    <h2 class="mb-4">Welcome Admin: <?= htmlspecialchars($_SESSION["username"]) ?></h2>
    <div class="row">
        <div class="col-md-3 col-sm-6">
            <div class="card text-bg-primary mb-3">
                <div class="card-body">
                    <h5 class="card-title">Total Staff</h5>
                    <p class="card-text fs-4"><?= $staffCount ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="card text-bg-warning mb-3">
                <div class="card-body">
                    <h5 class="card-title">Pending Leaves</h5>
                    <p class="card-text fs-4"><?= $pendingCount ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="card text-bg-success mb-3">
                <div class="card-body">
                    <h5 class="card-title">Approved Leaves</h5>
                    <p class="card-text fs-4"><?= $approvedCount ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="card text-bg-danger mb-3">
                <div class="card-body">
                    <h5 class="card-title">Rejected Leaves</h5>
                    <p class="card-text fs-4"><?= $rejectedCount ?></p>
                </div>
            </div>
        </div>
    </div>
    <hr>
    <p>Use the sidebar to manage leave requests and users.</p>
</div>
</body>
</html>
