<?php
include '../../connection.php';
error_reporting(1);

if (isset($_GET["uuid"])) {
    $uuid = $_GET["uuid"];
    
    // Fetch the user details to get the username and profile picture
    $sql = "SELECT * FROM admin_user WHERE uuid='$uuid'";
    $result = $conn->query($sql);
    $user = $result->fetch_assoc();

    // Check if the user exists
    if ($user) {
        $username = $user['username'];
        $profile_picture = $user['profile_picture'];  // Path to the profile picture

        // If the form is submitted, check if the username matches
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Check if the entered username matches the one in the database
            if ($_POST["username"] == $username) {
                // Delete the user from the database
                $sql_delete = "DELETE FROM admin_user WHERE uuid='$uuid'";

                if ($conn->query($sql_delete) === TRUE) {
                    // If profile picture exists, delete the old image file
                    if (file_exists($profile_picture) && $profile_picture != 'default_path_here') {
                        unlink($profile_picture);  // Delete the profile picture
                    }

                    echo "<script>
                            alert('User deleted successfully!');
                            window.location.href = 'display_user.php';  // Redirect to the users list page
                          </script>";
                } else {
                    echo "<script>alert('Error deleting user: " . $conn->error . "');</script>";
                }
            } else {
                echo "<script>alert('Username does not match. Deletion cancelled.');</script>";
            }
        }
    } else {
        echo "<script>alert('User not found.');</script>";
    }
    $conn->close();
} else {
    echo "<script>alert('User ID not specified.');</script>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Delete User</title>
</head>
<body>
    <h1>Delete User</h1>

    <form action="delete_user.php?uuid=<?= $uuid ?>" method="post">
        <p>Are you sure you want to delete the user: <strong><?= htmlspecialchars($username) ?></strong>?</p>
        <p>To confirm, please enter the username:</p>
        <input type="text" name="username" required><br><br>

        <button type="submit" onclick="return confirmDelete()">Delete User</button>
        <button type="button" onclick="window.location.href='display_users.php'">Cancel</button>
    </form>

    <script>
        // JavaScript function to confirm before deletion
        function confirmDelete() {
            var usernameInput = document.getElementsByName('username')[0].value;
            var username = '<?= htmlspecialchars($username) ?>';  // PHP value injected into JavaScript
            if (usernameInput !== username) {
                alert("Username does not match. Please enter the correct username to confirm.");
                return false; // Prevent form submission
            }
            return true; // Proceed with form submission
        }
    </script>
</body>
</html>
