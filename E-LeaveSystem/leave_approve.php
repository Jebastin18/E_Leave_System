<?php
require_once 'db.php';
session_start();
if (!isset($_SESSION["username"]) || $_SESSION["role"] !== "Admin") {
    header("Location: index.php");
    exit();
}
$sql = "INSERT INTO leave_requests (
    admin_remarks
) VALUES (?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s" ,  $admin_remarks, );
$sql = "SELECT id, username, name, apply_date, from_date, to_date, permission_type, reason, remarks, approved_status 
        FROM leave_requests 
        WHERE approved_status = 0 
        ORDER BY apply_date DESC";
$result = $conn->query($sql);
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['leave_id'], $_POST['action'])) {
    $leaveId = $_POST['leave_id'];
    $admin_remarks = $_POST['admin_remarks'];
    $status = $_POST['action'] === 'approve' ? 1 : 2;
    $stmt = $conn->prepare("SELECT approved_status FROM leave_requests WHERE id = ?");
    $stmt->bind_param("i", $leaveId);
    $stmt->execute();
    $stmt->bind_result($current_status);
    $stmt->fetch();
    $stmt->close();
    if ($current_status != 0) {
        $_SESSION['message'] = 'already_updated';
        header("Location: leave_approve.php");
        exit();
    }
    $update = $conn->prepare("UPDATE leave_requests SET admin_remarks = ?, approved_status = ? WHERE id = ?");
    $update->bind_param("sii", $admin_remarks, $status, $leaveId);
    $update->execute();
    header("Location: leave_approve.php?success=updated");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Leave Approval - Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">
<style>
html, body {
    margin: 0;
    padding: 0;
    height: 100%;
}
.container-fluid {
    padding-left: 0; 
}
.main-content {
    margin-left: 0; 
}
.sidebar {
    height: 100vh; 
    position: fixed; 
    top: 0;
    left: 0;
    width: 250px; 
    background-color: #343a40; 
    color: white; 
    z-index: 1; 
}
.content-wrapper {
    margin-left: 250px; 
    padding: 20px;
}
</style>
</head>
<body class="bg-light">
<?php include 'layout.php'; ?>
<div class="container-fluid"style="margin-left: 24%;">
<?php
if (isset($_SESSION['message'])) {
    if ($_SESSION['message'] === 'already_updated') {
        echo '<div class="alert alert-warning" style="width:50%;">This leave request has already been processed.</div>';
    } elseif ($_SESSION['message'] === 'updated') {
        echo '<div class="alert alert-success" style="width:50%;">Leave request updated successfully.</div>';
    }
    unset($_SESSION['message']);
}
?>
    <div class="row">
        <div class="col-md-9 mt-4">
            <div class="card shadow p-4 mt-5">
                <h2 class="mb-4">Leave Requests - Admin Panel</h2>
                <div class="table-responsive">
                    <table id="leaveTable" class="table table-bordered table-striped">
                        <thead class="table-dark">
                            <tr>
                                <th>Name</th>
                                <th>Apply Date</th>
                                <th>From</th>
                                <th>To</th>
                                <th>Permission</th>
                                <th>Reason</th>
                                <th>Remarks</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = $result->fetch_assoc()): ?>
                                <tr>
                                    <td><?= htmlspecialchars($row['name']) ?></td>
                                    <td><?= htmlspecialchars($row['apply_date']) ?></td>
                                    <td><?= htmlspecialchars($row['from_date']) ?></td>
                                    <td><?= htmlspecialchars($row['to_date']) ?></td>
                                    <td><?= htmlspecialchars($row['permission_type']) ?></td>
                                    <td><?= htmlspecialchars($row['reason']) ?></td>
                                    <td><?= htmlspecialchars($row['remarks']) ?></td>
                                    <td>
                                        <?php
                                            $status = (int)$row['approved_status'];
                                            if ($status === 1) {
                                                echo '<span class="badge bg-success">Approved</span>';
                                            } elseif ($status === 2) {
                                                echo '<span class="badge bg-danger">Rejected</span>';
                                            } else {
                                                echo '<span class="badge bg-warning text-dark">Pending</span>';
                                            }
                                        ?>
                                    </td>
                                    <td>
                                        <button 
                                            class="btn btn-sm btn-primary view-btn"
                                            data-id="<?= $row['id'] ?>"
                                            data-name="<?= htmlspecialchars($row['name']) ?>"
                                            data-apply="<?= $row['apply_date'] ?>"
                                            data-from="<?= $row['from_date'] ?>"
                                            data-to="<?= $row['to_date'] ?>"
                                            data-permission="<?= htmlspecialchars($row['permission_type']) ?>"
                                            data-reason="<?= htmlspecialchars($row['reason']) ?>"
                                            data-remarks="<?= htmlspecialchars($row['remarks']) ?>"                
                                            data-status="<?= $row['approved_status'] ?>"
                                            data-bs-toggle="modal"
                                            data-bs-target="#viewModal">
                                            View
                                        </button>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="viewModal" tabindex="-1" aria-labelledby="viewModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form method="POST" action="leave_approve.php">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Leave Request Details</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="leave_id" id="modalLeaveId">
          <div class="mb-2">
            <label class="form-label">Name</label>
            <input type="text" class="form-control" id="modalName" disabled>
          </div>
          <div class="mb-2">
            <label class="form-label">Apply Date</label>
            <input type="text" class="form-control" id="modalApply" disabled>
          </div>
          <div class="row mb-2">
            <div class="col">
              <label class="form-label">From Date</label>
              <input type="text" class="form-control" id="modalFrom" disabled>
            </div>
            <div class="col">
              <label class="form-label">To Date</label>
              <input type="text" class="form-control" id="modalTo" disabled>
            </div>
          </div>
          <div class="mb-2">
            <label class="form-label">Permission</label>
            <input type="text" class="form-control" id="modalPermission"  disabled>
          </div>
          <div class="mb-2">
            <label class="form-label">Reason</label>
            <input type="text" class="form-control" id="modalReason"  disabled>
          </div>
          <div class="mb-2">
            <label class="form-label">Remarks</label>
                <textarea class="form-control" id="modalRemarks" rows="3" disabled></textarea>
        </div>
          <div class="mb-2">
            <label class="form-label">Admin Remarks</label>
                <textarea class="form-control" name="admin_remarks" id="admin_remarks" rows="3"></textarea>
        </div>
        </div>
        <div class="modal-footer">
          <button type="submit" name="action" value="approve" class="btn btn-success">Approve</button>
          <button type="submit" name="action" value="reject" class="btn btn-danger">Reject</button>
        </div>
      </div>
    </form>
  </div>
</div>
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script>
    $(document).ready(function () {
        $('#leaveTable').DataTable();
        $('.view-btn').on('click', function () {
            $('#modalLeaveId').val($(this).data('id'));
            $('#modalName').val($(this).data('name'));
            $('#modalApply').val($(this).data('apply'));
            $('#modalFrom').val($(this).data('from'));
            $('#modalTo').val($(this).data('to'));
            $('#modalPermission').val($(this).data('permission'));
            $('#modalReason').val($(this).data('reason'));
            $('#modalRemarks').val($(this).data('remarks'));
        });
    });
</script>
</body>
</html>
