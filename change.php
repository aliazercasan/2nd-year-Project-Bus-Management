<?php
include("config.php");

// Handle login form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Retrieve user from the database
    $stmt = $conn->prepare("SELECT id, username, password FROM theadmin WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    // Verify password
    if ($user && password_verify($password, $user['password'])) {
        // Login successful
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        header("Location: dashboardAdmin.php");
        exit();
    } else {
        echo'<script>alert("Incorrect Username or Password...Please try again!")</script>';
    }

    $stmt->close();
}

// Handle password change form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['change_password'])) {
    $new_password = $_POST['new_password'];
    $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
    $user_id = $_SESSION['user_id'];

    // Update password in the database
    $stmt = $conn->prepare("UPDATE theadmin SET password = ? WHERE id = ?");
    $stmt->bind_param("si", $hashed_password, $user_id);
    $stmt->execute();
    $stmt->close();

    // Redirect to a success page or display a success message
    // For demonstration, let's redirect to the login page
    header("Location: logInadmin.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Log In</title>
    <style>
        /* Your CSS styles */
    </style>
</head>
<body>
    <!-- Your HTML code -->
    <div>
        <h1>Admin</h1>
        <h2>Log In</h2>
        <hr>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <!-- Login form -->
        </form>

        <h2>Change Password</h2>
        <hr>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <label for="new_password">New Password:</label>
            <input type="password" id="new_password" name="new_password" required><br>
            <button type="submit" name="change_password">Change Password</button>
        </form>
    </div>
</body>
</html>
