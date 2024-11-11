<?php
include '../../connection.php';
error_reporting(1);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $uuid = uniqid(true); // Generate a unique ID with a prefix "user-"
    $username = $_POST["username"];
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT); // Encrypt password
    $can_read = isset($_POST["can_read"]) ? 1 : 0;
    $can_write = isset($_POST["can_write"]) ? 1 : 0;
    $can_remove = isset($_POST["can_remove"]) ? 1 : 0;
    $role = $_POST["role"];

    // Check if the username already exists
    $sql_check = "SELECT * FROM admin_user WHERE username = '$username'";
    $result_check = $conn->query($sql_check);

    if ($result_check->num_rows > 0) {
        // If the username already exists, show an alert and stop further processing
        echo "<script>alert('Username already exists. Please choose a different username.');</script>";
    } else {
        // Handle the profile picture upload
        $target_dir = "../uploads/";
        $profile_pic = null;

        if (!empty($_FILES["profile_pic"]["name"])) {
            $profile_pic = $target_dir . basename($_FILES["profile_pic"]["name"]);
            if (move_uploaded_file($_FILES["profile_pic"]["tmp_name"], $profile_pic)) {
            } else {
                $profile_pic = null; // Set to null if the upload fails
            }
        }

        // Insert user into the database with UUID
        $sql = "INSERT INTO admin_user (uuid, username, password, profile_picture, read_access, write_access, remove_access, role) 
                VALUES ('$uuid', '$username', '$password', '$profile_pic', $can_read, $can_write, $can_remove, '$role')";

        if ($conn->query($sql) === TRUE) {
    // Successfully inserted user
            echo "<script>
            alert('User added successfully!');
          </script>";
          header('location:display_user.php');
            } else {
            echo "<script>alert('Error: " . $sql . " - " . $conn->error . "');</script>";
        }
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add New User</title>
    <link rel="stylesheet" href="../../css/add_user.css">
</head>
<body>

    <div class="form-container">
        <h1>Add New User</h1>
        <form action="add_user.php" method="post" enctype="multipart/form-data">
            <label>Username:</label><input type="text" name="username" required><br>
            <label>Password:</label><input type="password" name="password" required><br>
            <label>Profile Picture:</label>
            <input type="file" name="profile_pic" accept="image/*" onchange="previewImage(event)" required><br>
            <div class="preview-container">
                <img id="profilePreview" src="" alt="Profile Preview" class="profile-preview">
            </div>
            <label>Read:</label><input type="checkbox" name="can_read"><br>
            <label>Write/Edit:</label><input type="checkbox" name="can_write"><br>
            <label>Remove:</label><input type="checkbox" name="can_remove"><br>
            <label>Role:</label>
            <select name="role">
                <option value="Admin">Admin</option>
                <option value="User">User</option>
            </select><br>
            <button type="submit">Add User</button>
        </form>
    </div>
    <script>
        function previewImage(event) {
            const reader = new FileReader();
            reader.onload = function(){
                const preview = document.getElementById('profilePreview');
                preview.src = reader.result;
                preview.style.display = 'block';
            }
            reader.readAsDataURL(event.target.files[0]);
        }
    </script>
</body>
</html>
