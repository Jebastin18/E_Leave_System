<?php
require_once 'db.php';
session_start();
if (!isset($_SESSION["username"]) || $_SESSION["role"] !== "Staff") {
    header("Location: index.php");
    exit();
}
$username = $_SESSION["username"];
$sql = "SELECT name, apply_date, from_date, to_date, permission_type, reason, remarks, admin_remarks, approved_status FROM leave_requests WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$leaveData = [];
while ($row = $result->fetch_assoc()) {
    $leaveData[] = $row;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Leave Report</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
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
        <div class="card shadow p-4">
            <h2 class="mb-4">My Leave Report</h2>
            <div class="row mb-3">
                <div class="col-md-3">
                    <label for="filterFrom" class="form-label">From Date</label>
                    <input type="date" id="filterFrom" class="form-control">
                </div>
                <div class="col-md-3">
                    <label for="filterTo" class="form-label">To Date</label>
                    <input type="date" id="filterTo" class="form-control">
                </div>
                <div class="col-md-3 d-flex align-items-end">
                    <button class="btn btn-primary me-2" onclick="filterTable()">Filter</button>
                    <button class="btn btn-secondary" onclick="resetTable()">Reset</button>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered table-striped" id="leaveTable">
                    <thead class="table-dark">
                        <tr>
                            <th>Name</th>
                            <th>Apply Date</th>
                            <th>From</th>
                            <th>To</th>
                            <th>Permission</th>
                            <th>Reason</th>
                            <th>Remarks</th>
                            <th>Approver Remarks</th> 
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody id="tableBody">
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script>
    const leaveData = <?= json_encode($leaveData) ?>;
    const statusMap = {
        0: "Pending",
        1: "Approved",
        2: "Rejected"
    };
    const tableBody = document.getElementById("tableBody");
    function loadTable(data) {
        tableBody.innerHTML = "";
        if (data.length === 0) {
            tableBody.innerHTML = `<tr><td colspan="9" class="text-center text-muted">No leave records found for selected date range.</td></tr>`;
            return;
        }
        data.forEach(leave => {
            const row = document.createElement("tr");
            row.innerHTML = `
                <td>${leave.name}</td>
                <td>${leave.apply_date}</td>
                <td>${leave.from_date}</td>
                <td>${leave.to_date}</td>
                <td>${leave.permission_type}</td>
                <td>${leave.reason}</td>
                <td>${leave.remarks}</td>  
                <td>${leave.admin_remarks}</td>       
                <td><span class="badge ${leave.approved_status == 1 ? 'bg-success' : leave.approved_status == 2 ? 'bg-danger' : 'bg-warning text-dark'}">
                    ${statusMap[leave.approved_status]}
                </span></td>
            `;
            tableBody.appendChild(row);
        });
    }
    loadTable(leaveData);
    function filterTable() {
        const fromDate = document.getElementById("filterFrom").value;
        const toDate = document.getElementById("filterTo").value;
        if (!fromDate || !toDate) {
            alert("Please select both From and To dates.");
            return;
        }
        const filtered = leaveData.filter(leave => {
            return leave.from_date >= fromDate && leave.to_date <= toDate;
        });
        loadTable(filtered);
    }
    function resetTable() {
        document.getElementById("filterFrom").value = "";
        document.getElementById("filterTo").value = "";
        loadTable(leaveData);
    }
    $(document).ready(function() {
        $('#leaveTable').DataTable({
            paging: true,
            ordering: true,
            info: true,
            responsive: true
        });
    });
</script>
</body>
</html>
