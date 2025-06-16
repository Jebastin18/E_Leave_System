<?php
require_once 'db.php';
session_start();
if (!isset($_SESSION["username"]) || $_SESSION["role"] !== "Admin") {
    header("Location: index.php");
    exit();
}
$errors = [];
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST["username"]);
    $name = trim($_POST["name"]);
    $password = trim($_POST["password"]);
    $role = $_POST["role"];
    $status = $_POST["status"];
    if (strlen($username) < 5) {
        $errors[] = "Username must be at least 5 characters.";
    }
    if (strlen($name) > 25) {
        $errors[] = "Name cannot exceed 25 characters.";
    }
    if (strlen($password) < 8) {
        $errors[] = "Password must be at least 8 characters.";
    }
    if (empty($errors)) {
        $hashedPassword = $password;
        $stmt = $conn->prepare("INSERT INTO users (username, name, password, role, status) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $username, $name, $hashedPassword, $role, $status);
        $stmt->execute();
        header("Location: usermanagement.php");
        exit();
    }
}
$result = $conn->query("SELECT * FROM users ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Management</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
</head>
<body class="bg-light">
<?php include 'layout.php'; ?>
<div class="container mt-5" style="margin-left: 24%; width: 75%;">
    <?php if (!empty($errors)): ?>
        <div class="alert alert-danger">
            <ul class="mb-0">
                <?php foreach ($errors as $e): ?>
                    <li><?= htmlspecialchars($e) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>
    <div class="card shadow mb-4">
        <div class="card-header bg-primary text-white">Add New User</div>
        <div class="card-body">
            <form method="POST" action="usermanagement.php">
                <div class="row">
                    <div class="mb-3 col-md-6">
                        <label class="form-label">Username</label>
                        <input type="text" name="username" class="form-control" maxlength="5" required>
                    </div>
                    <div class="mb-3 col-md-6">
                        <label class="form-label">Name</label>
                        <input type="text" name="name" class="form-control" maxlength="25" required>
                    </div>
                    <div class="mb-3 col-md-6">
                        <label class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" minlength="8" maxlength="8" required>
                    </div>
                    <div class="mb-3 col-md-3">
                        <label class="form-label">Role</label>
                        <select name="role" class="form-select" required>
                            <option value="Staff">Staff</option>
                            <option value="Admin">Admin</option>
                        </select>
                    </div>
                    <div class="mb-3 col-md-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select" required>
                            <option value="Active">Active</option>
                            <option value="Inactive">Inactive</option>
                        </select>
                    </div>
                </div>
                <button type="submit" class="btn btn-success">Add User</button>
            </form>
        </div>
    </div>
    <div class="card shadow">
        <div class="card-header bg-primary text-white">User Report</div>
        <div class="card-body">
            <table id="usersTable" class="table table-striped" style="width:100%">
                <thead>
                    <tr>
                        <th>Username</th>
                        <th>Name</th>
                        <th>Password</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($user = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($user['username']) ?></td>
                        <td><?= htmlspecialchars($user['name']) ?></td>
                        <td><?= htmlspecialchars($user['password']) ?></td>
                        <td><?= htmlspecialchars($user['role']) ?></td>
                        <td><?= htmlspecialchars($user['status']) ?></td>
                        <td>
                            <button class="btn btn-primary btn-sm edit-btn"
                                    data-id="<?= $user['id'] ?>"
                                    data-username="<?= htmlspecialchars($user['username']) ?>"
                                    data-name="<?= htmlspecialchars($user['name']) ?>"
                                    data-password="<?= htmlspecialchars($user['password']) ?>"
                                    data-role="<?= htmlspecialchars($user['role']) ?>"
                                    data-status="<?= htmlspecialchars($user['status']) ?>">
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
<div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editUserModalLabel">Edit User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editUserForm">
                <div class="modal-body">
                    <input type="hidden" name="id" id="editUserId">
                    <div class="mb-3">
                        <label class="form-label">Name</label>
                        <input type="text" name="name" class="form-control" id="editName" maxlength="25" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="text" name="password" class="form-control" id="editPassword" maxlength="8"minlength="8" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Role</label>
                        <select name="role" class="form-select" id="editRole" required>
                            <option value="Staff">Staff</option>
                            <option value="Admin">Admin</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select" id="editStatus" required>
                            <option value="Active">Active</option>
                            <option value="Inactive">Inactive</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.7.0.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
$(document).ready(function() {
    $('#usersTable').DataTable();
    $('.edit-btn').click(function() {
        var user = {
            id: $(this).data('id'),
            username: $(this).data('username'),
            name: $(this).data('name'),
            password: $(this).data('password'),
            role: $(this).data('role'),
            status: $(this).data('status')
        };
        $('#editUserId').val(user.id);
        $('#editName').val(user.name);
        $('#editPassword').val(user.password);
        $('#editRole').val(user.role);
        $('#editStatus').val(user.status);
        $('#editUserModal').modal('show');
    });
    $('#editUserForm').submit(function(e) {
        e.preventDefault(); 
        $.ajax({
            url: 'update_user.php',
            method: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                $('#editUserModal').modal('hide');
                location.reload();
            },
            error: function(xhr) {
                alert('Error: ' + xhr.responseText);
            }
        });
    });
});
</script>
</body>
</html>