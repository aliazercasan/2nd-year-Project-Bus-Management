<?php
session_start();
require_once "config.php";
include("headerAdmin.php");

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Initialize variables for form inputs and user information
$username = "";
$user = null;
$updateSuccess = false;

// Handle form submission to search for user account
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['search'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);

    // Retrieve user information from the database based on the username
    $stmt = $conn->prepare("SELECT id, firstname, lastname, age, address, username, email, busID FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    // Close the statement
    $stmt->close();
}

// Handle form submission to update user information
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
    // Retrieve and sanitize form data
    $user_id = mysqli_real_escape_string($conn, $_POST['user_id']);
    $firstname = mysqli_real_escape_string($conn, $_POST['firstname']);
    $lastname = mysqli_real_escape_string($conn, $_POST['lastname']);
    $age = intval($_POST['age']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $busID = intval($_POST['busID']);

    // Check if the entered busID already exists for another user
    $stmt_check = $conn->prepare("SELECT id FROM users WHERE busID = ? AND id != ?");
    $stmt_check->bind_param("ii", $busID, $user_id);
    $stmt_check->execute();
    $result_check = $stmt_check->get_result();

    if ($result_check->num_rows > 0) {
        // BusID already exists for another user
        echo "<script>alert('Bus ID already exists for another user.');</script>";
    } else {
        // Update user information in the database
        $stmt = $conn->prepare("UPDATE users SET firstname = ?, lastname = ?, age = ?, address = ?, username = ?, email = ?, busID = ? WHERE id = ?");
        $stmt->bind_param("ssisssii", $firstname, $lastname, $age, $address, $username, $email, $busID, $user_id);

        if ($stmt->execute()) {
            // Update successful
            $updateSuccess = true;
        } else {
            echo "Error: " . $conn->error;
        }

        $stmt->close();
    }

    $stmt_check->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update your driver Account</title>
    <style>
        body {
            background: radial-gradient(rgba(0, 0, 0, 0.8), rgba(0, 0, 0, 0.7)), url(images/adminback.jpg) no-repeat;
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            text-align: center;
            color: white;
        }

        .container {
            background: linear-gradient(135deg, rgba(225, 225, 225, 0.1), rgba(225, 225, 225, 0));
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            width: 300px;
            padding: 10px;
            border-radius: 10px;
            box-shadow: 3px 3px 1px black inset, 2px 2px 1px black inset, 2px 2px 1px black inset, 2px 2px 10px black inset;
            border: 1px solid white;
            margin-top: 90px;
        }

        .mother {
            display: flex;
            justify-content: center;
            height: 42vh;
        }

        .hori {
            width: 70%;
            margin-left: 50px;
            margin-top: 10px;
        }

        input {
            padding: 5px;
            border-radius: 5px;
        }

        button {
            margin-top: 20px;
            width: 30%;
            padding: 5px;
            border-radius: 5px;
            transition: ease-in-out 0.2s;
            margin-bottom: 10px;
        }

        button:hover {
            background-color: #80bfff;
        }

        h2 {
            margin-top: 5px;
            letter-spacing: 1px;
        }

        .back {
            color: white;
            margin-left: -230px;
            text-decoration: none;
        }

        .back:hover {
            color: red;
        }
        .form{
            background: linear-gradient(135deg, rgba(225, 225, 225, 0.1), rgba(225, 225, 225, 0));
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            width: 300px;
            padding: 10px;
            border-radius: 10px;
            box-shadow: 3px 3px 1px black inset, 2px 2px 1px black inset, 2px 2px 1px black inset, 2px 2px 10px black inset;
            border: 1px solid white;
            margin-top: 40px;
            margin-left: -10px;
        }
    </style>
</head>

<body>
    <div class="mother">

        <div class="container">
            <h2 class="update">Update driver's account</h2>
            <hr class="hori">
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <label for="username"></label><br>
                <input type="text" id="username" name="username" value="<?php echo $username; ?>" placeholder="Username"><br>
                <button type="submit" name="search" class="btn-update">Search</button><br>
                <a href="dashboardAdmin.php" class="back">Back</a>
            </form>

            <?php if ($user) { ?>
                <div class="form">

                    <h2 class="info">User Information</h2>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
                        
                        <label for="firstname">Firstname:</label><br>
                        <input type="text" id="firstname" name="firstname" value="<?php echo $user['firstname']; ?>" required><br>
                        
                        <label for="lastname">Lastname:</label><br>
                        <input type="text" id="lastname" name="lastname" value="<?php echo $user['lastname']; ?>" required><br>
                        
                        <label for="age">Age:</label><br>
                        <input type="number" id="age" name="age" value="<?php echo $user['age']; ?>" required><br>
                        
                        <label for="address">Address:</label><br>
                        <input type="text" id="address" name="address" value="<?php echo $user['address']; ?>" required><br>
                        
                        <label for="username">Username:</label><br>
                        <input type="text" id="username" name="username" value="<?php echo $user['username']; ?>" required><br>
                        
                        <label for="email">Email:</label><br>
                        <input type="email" id="email" name="email" value="<?php echo $user['email']; ?>" required><br>
                        
                        <label for="busID">Bus ID:</label><br>
                        <input type="number" id="busID" name="busID" value="<?php echo $user['busID']; ?>" required><br>
                        
                        <button type="submit" name="update" class="btn-update">Update</button>
                    </form>
                </div>
            <?php } ?>

            <?php if ($updateSuccess) { ?>
                <script>
                    alert('Updated Successfully');
                </script>
            <?php } ?>
        </div>
    </div>
</body>

</html>