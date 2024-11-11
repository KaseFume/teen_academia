<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Settings</title>
    <link rel="stylesheet" href="css/admin panel.css">
    <link rel="stylesheet" href="css/setting.css">
</head>
<body>
    <?php include 'connection.php'; // Include connection to database ?>

    <div class="admin-panel">
        <!-- Sidebar -->
        <div class="sidebar">
            <div class="sidebar-header">
                <h2>Admin Panel</h2>
            </div>
            <ul class="nav-list">
                <li class="nav-item"><a href="admin_panel.php">Dashboard</a></li>
                <li class="nav-item"><a href="display_user.php">Users</a></li>
                <li class="nav-item active"><a href="setting.php">Settings</a></li>
                <li class="nav-item"><a href="logs.php">Logs</a></li>
                <li class="nav-item"><a href="index.php">Logout</a></li>
            </ul>
        </div>

        <!-- Main content area -->
        <div class="main-content">
            <!-- Header -->
            <div class="header">
                <h1>Settings</h1>
            </div>

            <!-- Dashboard Content: Stats -->
            <div class="dashboard-content">
                <div class="stats-table table">
                    <table>
                        <tr class="table-heading">
                            <th>Youths</th>
                            <th>Volunteers</th>
                            <th>Contributions</th>
                            <th>Contents</th>
                            <th>Edit</th>
                        </tr>
                        <tr class="table-data">
                            <?php
                            // Fetch counts for each category
                            $youths = $conn->query("SELECT COUNT(*) AS count FROM youths")->fetch_assoc()['count'];
                            $volunteers = $conn->query("SELECT COUNT(*) AS count FROM volunteers")->fetch_assoc()['count'];
                            $contributions = $conn->query("SELECT COUNT(*) AS count FROM contributions")->fetch_assoc()['count'];
                            $contents = $conn->query("SELECT COUNT(*) AS count FROM contents")->fetch_assoc()['count'];
                            ?>
                            <td><?php echo $youths; ?></td>
                            <td><?php echo $volunteers; ?></td>
                            <td><?php echo $contributions; ?></td>
                            <td><?php echo $contents; ?></td>
                            <td><a href="">Edit</a></td>
                        </tr>
                    </table>
                </div>
            </div>

            <!-- Announcements Section -->
            <div class="header">
                <h1>Announcements</h1>
                <div class="add-new-button">
                    <button>Add New Announcements</button>
                </div>
            </div>
            <div class="dashboard-content">
                <div class="image-slider-table">
                    <table>
                        <tr class="table-heading">
                            <th>ID</th>
                            <th>Title</th>
                            <th>Date Time</th>
                            <th>Description</th>
                            <th>Image</th>
                            <th>Announced By</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>
                        <?php
                        $result = $conn->query("SELECT * FROM announcements");
                        while ($row = $result->fetch_assoc()) {
                        ?>
                        <tr class="table-data">
                            <td><?php echo $row['id']; ?></td>
                            <td><?php echo $row['title']; ?></td>
                            <td><?php echo $row['date_time']; ?></td>
                            <td><?php echo $row['description']; ?></td>
                            <td><img src="<?php echo $row['image']; ?>" alt="Image"></td>
                            <td><?php echo $row['announced_by']; ?></td>
                            <td><a href="edit_announcement.php?id=<?php echo $row['id']; ?>">Edit</a></td>
                            <td><a href="delete_announcement.php?id=<?php echo $row['id']; ?>">Delete</a></td>
                        </tr>
                        <?php } ?>
                    </table>
                </div>
            </div>

            <!-- Repeat similar sections for other tables -->
            <!-- Example for Image Slider Section -->
            <div class="header">
                <h1>Image Slider</h1>
                <div class="add-new-button">
                    <button>Add New Image</button>
                </div>
            </div>
            <div class="dashboard-content">
                <div class="image-slider-table">
                    <table>
                        <tr class="table-heading">
                            <th>Image No</th>
                            <th>Image</th>
                            <th>Link To</th>
                            <th>Modified By</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>
                        <?php
                        $result = $conn->query("SELECT * FROM image_slider");
                        while ($row = $result->fetch_assoc()) {
                        ?>
                        <tr class="table-data">
                            <td><?php echo $row['image_no']; ?></td>
                            <td><img src="<?php echo $row['image']; ?>" alt="Image"></td>
                            <td><a href="<?php echo $row['link']; ?>" target="_blank">Link To</a></td>
                            <td><?php echo $row['modified_by']; ?></td>
                            <td><a href="edit_image.php?image_no=<?php echo $row['image_no']; ?>">Edit</a></td>
                            <td><a href="delete_image.php?image_no=<?php echo $row['image_no']; ?>">Delete</a></td>
                        </tr>
                        <?php } ?>
                    </table>
                </div>
            </div>

            <!-- Repeat for other sections like Podcasts, Reviews, Articles, Vlogs -->
            
        </div>
    </div>
    <script src="js/admin panel.js"></script>
</body>
</html>
