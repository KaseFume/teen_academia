<?php
include '../../connection.php'; // Ensure the correct path for the database connection
error_reporting(1);

// Fetch users from the database
$sql = "SELECT * FROM admin_user"; // Replace 'admin_user' with your actual table name
$result = $conn->query($sql);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - User Management</title>
    <link rel="stylesheet" href="../../css/display_user.css">
</head>
<body>
    <div class="admin-panel">
        <!-- Sidebar -->
        <div class="sidebar">
            <div class="sidebar-header">
                <h2>Admin Panel</h2>
            </div>
            <ul class="nav-list">
                <li class="nav-item"><a href="../../admin_panel.html">Dashboard</a></li>
                <li class="nav-item active"><a href="display_user.php">Users</a></li>
                <li class="nav-item"><a href="../../setting.html">Settings</a></li>
                <li class="nav-item"><a href="../../logs.html">Logs</a></li>
                <li class="nav-item"><a href="../../index.html">Logout</a></li>
            </ul>
        </div>

        <!-- Main content area -->
        <div class="main-content">
            <!-- Header -->
            <div class="header">
                <h1>User Management</h1>
                <a href="add_user.php" class="btn-new-user">+ Add New User</a>
            </div>

            <!-- User Table -->
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>UUID</th>
                            <th>Username</th>
                            <th>Password</th>
                            <th>Profile Pic</th>
                            <th>Read</th>
                            <th>Write/Edit</th>
                            <th>Remove</th>
                            <th>Role</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($result->num_rows > 0) {
                            while($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . $row["uuid"] . "</td>";
                                echo "<td>" . $row["username"] . "</td>";
                                echo "<td>********</td>";  // Masking the password
                                echo "<td><img src='" . $row["profile_picture"] . "' alt='Profile Pic' class='profile-pic'></td>";
                                echo "<td><input type='checkbox' " . ($row["read_access"] ? "checked" : "") . " disabled></td>";
                                echo "<td><input type='checkbox' " . ($row["write_access"] ? "checked" : "") . " disabled></td>";
                                echo "<td><input type='checkbox' " . ($row["remove_access"] ? "checked" : "") . " disabled></td>";
                                echo "<td>" . $row["role"] . "</td>";
                                // Edit and Delete buttons (can link to their respective edit and delete pages)
                                echo "<td><a href='edit_user.php?uuid=" . $row["uuid"] . "' class='btn-edit'>Edit</a></td>";
                                echo "<td><a href='delete_user.php?uuid=" . $row["uuid"] . "' class='btn-delete'>Delete</a></td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='10'>No users found.</td></tr>";
                        }
                        $conn->close();
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script src="js/display_user.js"></script>
</body>
</html>
