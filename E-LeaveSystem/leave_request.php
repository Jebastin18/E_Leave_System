<?php
require_once 'db.php';
session_start();
if (!isset($_SESSION["username"])) {
    header("Location: index.php");
    exit();
}
$username = $_SESSION["username"];
$query = "SELECT name FROM users WHERE username = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $username);
$stmt->execute();
$stmt->bind_result($fullName);
$stmt->fetch();
$stmt->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leave Request Form</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .main-content {
            z-index: 1; 
            margin-left: 250px; 
        }
    </style>
</head>
<body class="bg-light">
<?php include 'layout.php'; ?>
<div class="main-content p-4">
    <div class="container mt-4">
        <div class="card shadow p-4 mx-auto" style="max-width: 800px;">
            <h2 class="mb-4">Leave Request</h2>
            <form method="POST" action="process_leave.php">
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" class="form-control" name="name" id="name" value="<?= htmlspecialchars($fullName) ?>" readonly>
                </div>
                <div class="mb-3">
                    <label for="apply_date" class="form-label">Apply Date</label>
                    <input type="date" class="form-control" name="apply_date" id="apply_date" value="<?php echo date('Y-m-d'); ?>" readonly>
                </div>
                <div class="mb-3">
                    <label for="from_date" class="form-label">From Date</label>
                    <input type="date" class="form-control" name="from_date" id="from_date" required>
                </div>
                <div class="mb-3">
                    <label for="to_date" class="form-label">To Date</label>
                    <input type="date" class="form-control" name="to_date" id="to_date" required>
                </div>
                <div class="mb-3">
                    <label for="Permission" class="form-label">Permission</label>
                    <select class="form-select" name="Permission" id="Permission" required>
                        <option value="">-- Select Permission --</option>
                        <option value="od">OD</option>
                        <option value="Half day">Half day</option>
                        <option value="Full day">Full Day</option>
                        <option value="Others">Others</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="reason" class="form-label">Reason</label>
                    <select class="form-select" name="reason" id="reason" required>
                        <option value="">-- Select Reason --</option>
                        <option value="Sick Leave">Health Issue</option>
                        <option value="Personal Leave">Personal Leave</option>
                        <option value="Emergency">Emergency</option>
                        <option value="Vacation">Vacation</option>
                        <option value="CL">CL</option>
                        <option value="Others">Others</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="remarks" class="form-label">Remarks</label>
                    <textarea class="form-control" name="remarks" id="remarks" rows="4" placeholder="Enter any remarks..." maxlength="100" required></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
</div>
</body>
</html>
