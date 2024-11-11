<?php
include '../../connection.php';
error_reporting(1);

if (isset($_GET["uuid"])) {
    $uuid = $_GET["uuid"];

    // Fetch the user details based on uuid
    $sql = "SELECT * FROM admin_user WHERE uuid='$uuid'";
    $result = $conn->query($sql);
    $user = $result->fetch_assoc();

    // Check if the form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = $_POST["username"];
        $profile_pic = $user['profile_picture']; // Default to the current profile picture

        // Handle profile picture upload
        if (!empty($_FILES["profile_pic"]["name"])) {
            // Define target directory for the uploaded file
            $target_dir = "../uploads/";
            $target_file = $target_dir . basename($_FILES["profile_pic"]["name"]);
            
            // Attempt to upload the file
            if (move_uploaded_file($_FILES["profile_pic"]["tmp_name"], $target_file)) {
                // If the upload is successful, delete the old image file
                if (file_exists($user['profile_picture']) && $user['profile_picture'] != 'default_path_here') {
                    unlink($user['profile_picture']); // Delete the old image
                }

                // Set the new profile picture path
                $profile_pic = $target_file;
            } else {
                echo "<script>alert('Sorry, there was an error uploading your file.');</script>";
            }
        }

        // Handle permissions and role
        $can_read = isset($_POST["can_read"]) ? 1 : 0;
        $can_write = isset($_POST["can_write"]) ? 1 : 0;
        $can_remove = isset($_POST["can_remove"]) ? 1 : 0;
        $role = $_POST["role"];

        // Check if the new username already exists in the database
        $sql = "SELECT * FROM admin_user WHERE username='$username' AND uuid != '$uuid'";  // Exclude current user's UUID
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // If the username is already taken, show an error message
            echo "<script>
                    alert('Username is already taken. Please choose another one.');
                    window.location.href = 'edit_user.php?uuid=$uuid';
                  </script>";
        } else {
            // Update user query using uuid if the username is unique
            $sql = "UPDATE admin_user SET username='$username', profile_picture='$profile_pic', read_access=$can_read, write_access=$can_write, remove_access=$can_remove, role='$role' WHERE uuid='$uuid'";

            if ($conn->query($sql) === TRUE) {
                // Show success alert and redirect after a brief delay
                echo "<script>
                        alert('User updated successfully!');
                      </script>";
                header('location:display_user.php');
            } else {
                echo "Error updating user: " . $conn->error;
            }
        }
    }

    $conn->close();
} else {
    die("User UUID not specified.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit User</title>
    <link rel="stylesheet" href="../../css/edit_user.css">
</head>
<body>
    <div class="form-container">
    <h1>Edit User</h1>
    <form action="edit_user.php?uuid=<?= $uuid ?>" method="post" enctype="multipart/form-data">
        <label>Username:</label>
        <input type="text" name="username" value="<?= htmlspecialchars($user['username']) ?>" required><br>

        <!-- Profile Picture Input -->
        <label>Profile Picture:</label>
        <input type="file" name="profile_pic" id="profile_pic" onchange="previewImage(event)">
        <br>

        <!-- Image preview -->
        <div class="preview-container">
            <!-- Show current profile picture if available -->
            <img src="<?= htmlspecialchars($user['profile_picture']) ?>" alt="Profile Picture" id="profile_preview" class="profile-preview" style="display: block;">
        </div>

        <!-- Read Access -->
        <label>Read:</label>
        <input type="checkbox" name="can_read" <?= $user['read_access'] ? 'checked' : '' ?>><br>
        
        <!-- Write/Edit Access -->
        <label>Write/Edit:</label>
        <input type="checkbox" name="can_write" <?= $user['write_access'] ? 'checked' : '' ?>><br>
        
        <!-- Remove Access -->
        <label>Remove:</label>
        <input type="checkbox" name="can_remove" <?= $user['remove_access'] ? 'checked' : '' ?>><br>
        
        <!-- Role Selection -->
        <label>Role:</label>
        <select name="role">
            <option value="Admin" <?= $user['role'] == 'Admin' ? 'selected' : '' ?>>Admin</option>
            <option value="User" <?= $user['role'] == 'User' ? 'selected' : '' ?>>User</option>
        </select><br>
        
        <button type="submit">Update User</button>
    </form>
    </div>

    <script>
        // Image preview function
        function previewImage(event) {
            var reader = new FileReader();
            reader.onload = function() {
                var output = document.getElementById('profile_preview');
                output.src = reader.result;
            };
            reader.readAsDataURL(event.target.files[0]);
        }
    </script>
</body>
</html>
