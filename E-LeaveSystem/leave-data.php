<?php
include 'db.php';
$columns = ['name', 'apply_date', 'from_date', 'to_date', 'permission_type', 'reason', 'remarks', 'admin_remarks', 'approved_status'];
$limit = $_POST['length'];
$start = $_POST['start'];
$order_column = $columns[$_POST['order'][0]['column']];
$order_dir = $_POST['order'][0]['dir'];
$where = "WHERE 1=1";
if (!empty($_POST['fromDate'])) {
    $from = $_POST['fromDate'];
    $where .= " AND apply_date >= '$from'";
}
if (!empty($_POST['toDate'])) {
    $to = $_POST['toDate'];
    $where .= " AND apply_date <= '$to'";
}
if (!empty($_POST['name'])) {
    $name = $conn->real_escape_string($_POST['name']);
    $where .= " AND name = '$name'";
}
if ($_POST['status'] !== '') {
    $status = (int)$_POST['status'];
    $where .= " AND approved_status = $status";
}
$totalRecords = $conn->query("SELECT COUNT(*) AS total FROM leave_requests")->fetch_assoc()['total'];
$filteredRecords = $conn->query("SELECT COUNT(*) AS total FROM leave_requests $where")->fetch_assoc()['total'];
$sql = "SELECT * FROM leave_requests $where ORDER BY $order_column $order_dir LIMIT $start, $limit";
$result = $conn->query($sql);
$data = [];
while ($row = $result->fetch_assoc()) {
    $status = '<span class="badge bg-warning text-dark">Pending</span>';
    if ((int)$row['approved_status'] === 1) $status = '<span class="badge bg-success">Approved</span>';
    elseif ((int)$row['approved_status'] === 2) $status = '<span class="badge bg-danger">Rejected</span>';
    $data[] = [
        'name' => htmlspecialchars($row['name']),
        'apply_date' => htmlspecialchars($row['apply_date']),
        'from_date' => htmlspecialchars($row['from_date']),
        'to_date' => htmlspecialchars($row['to_date']),
        'permission_type' => htmlspecialchars($row['permission_type']),
        'reason' => htmlspecialchars($row['reason']),
        'remarks' => htmlspecialchars($row['remarks']),
        'admin_remarks' => htmlspecialchars($row['admin_remarks']),
        'approved_status' => $status
    ];
}
echo json_encode([
    "draw" => intval($_POST['draw']),
    "recordsTotal" => $totalRecords,
    "recordsFiltered" => $filteredRecords,
    "data" => $data
]);
?>
