<?php include 'db.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Leave Report</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/dataTables.bootstrap5.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
</head>
<body>
<?php include 'layout.php'; ?>
<div class="container-fluid" style="margin-left: 24%; width: 75%;">
    <div class="row">
        <div class="col-md-12 mt-4">
            <div class="card shadow p-4 mt-5">
                <h2 class="mb-4">Leave Report</h2>
                <div class="row mb-3">
                    <div class="col-md-3">
                        <label>Apply From Date</label>
                        <input type="date" id="applyFromDate" class="form-control">
                    </div>
                    <div class="col-md-3">
                        <label>Apply To Date</label>
                        <input type="date" id="applyToDate" class="form-control">
                    </div>
                    <div class="col-md-3">
                        <label>Filter by Name</label>
                        <select id="nameFilter" class="form-select">
                            <option value="">All</option>
                            <?php
                            $names = $conn->query("SELECT DISTINCT name FROM leave_requests ORDER BY name ASC");
                            while ($n = $names->fetch_assoc()):
                            ?>
                                <option value="<?= htmlspecialchars($n['name']) ?>"><?= htmlspecialchars($n['name']) ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label>Status</label>
                        <select id="statusFilter" class="form-select">
                            <option value="">All</option>
                            <option value="0">Pending</option>
                            <option value="1">Approved</option>
                            <option value="2">Rejected</option>
                        </select>
                    </div>
                    <div class="col-md-1 d-flex align-items-end">
                        <button class="btn btn-primary" id="applyFilter">Filter</button>
                    </div>
                </div>
                <div class="table-responsive">
                    <table id="reportTable" class="table table-bordered table-striped">
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
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.5/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
$(document).ready(function () {
    const today = new Date().toISOString().split('T')[0];
    if (!$('#applyFromDate').val()) {
        $('#applyFromDate').val(today);
    }
    if (!$('#applyToDate').val()) {
        $('#applyToDate').val(today);
    }
    $('#nameFilter').select2();
    let table = $('#reportTable').DataTable({
    processing: true,
    serverSide: true,
    info: true,
    ajax: {
        url: 'leave-data.php',
        type: 'POST',
        data: function (d) {
            d.fromDate = $('#applyFromDate').val();
            d.toDate = $('#applyToDate').val();
            d.name = $('#nameFilter').val();
            d.status = $('#statusFilter').val();
        }
    },
    columns: [
        { data: 'name' },
        { data: 'apply_date' },
        { data: 'from_date' },
        { data: 'to_date' },
        { data: 'permission_type' },
        { data: 'reason' },
        { data: 'remarks' },
        { data: 'admin_remarks' },
        { data: 'approved_status' }
    ],
    language: {
        infoFiltered: "" 
    }
});
    $('#applyFilter').on('click', function () {
        table.ajax.reload();
    });
});
</script>
</body>
</html>
