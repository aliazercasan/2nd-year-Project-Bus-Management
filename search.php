<?php
// Include database configuration
include("config.php");
include("header.php");

// Initialize variables
$userID = "";
$userInfo = null;
$error_message = "";

// Check if the form is submitted with a user ID
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['search'])) {
    // Sanitize and get the user ID
    $userID = trim($_POST['userID']);

    // Prepare and execute the SQL statement to retrieve user information based on the provided ID
    $sql = "SELECT u.id, u.firstname, u.age, u.busID, b.route AS routeID 
            FROM users u 
            LEFT JOIN bus b ON u.busID = b.busID 
            WHERE u.id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $userID);

    if (!mysqli_stmt_execute($stmt)) {
        $error_message = "Error executing statement: " . mysqli_error($conn);
    } else {
        // Bind the result to variables
        $result = mysqli_stmt_get_result($stmt);
        $userInfo = mysqli_fetch_assoc($result);

        if (!$userInfo) {
            echo '<script>alert("User not found!")</script>';
        }
    }

    // Close the statement
    mysqli_stmt_close($stmt);
}

// Close the database connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Search</title>
    <style>
        body {
            background: radial-gradient(rgba(0, 0, 0, 0.8), rgba(0, 0, 0, 0.7)), url(images/background2.jpg) no-repeat;
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
            height: 45vh;
        }

        hr {
            width: 70%;
            margin-left: 50px;
            margin-top: 20px;
        }

        input {
            padding: 5px;
            border-radius: 5px;
        }

        button {
            margin-bottom: 10px;
            margin-top: 20px;
            width: 30%;
            padding: 5px;
            border-radius: 5px;
            transition: ease-in-out 0.2s;
        }

        button:hover {
            background-color: #80bfff;
        }

        h2 {
            margin-top: 20px;
            letter-spacing: 2px;
        }

        table {
            margin-top: 50px;
            width: 900px;
            border: none;
            margin-left: -290px;
        }

        th {
            padding: 10px;
            background-color: #ff6666;
            font-weight: 900;
            font-size: 20px;
        }

        td {
            padding: 5px;
            background-color: #999999;
            font-size: 20px;
        }

        .back {
            color: white;
            margin-left: -170px;
        }

        .back:hover {
            color: red;
        }

    </style>

</head>

<body>
    <div class="mother">

        <div class="container">
            <h2>Search your details</h2>
            <hr>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <label for="userID"></label><br>
                <input type="number" id="userID" name="userID" required value="<?php echo htmlspecialchars($userID); ?>" placeholder="User ID"><br>
                <button type="submit" name="search">Search</button><br>
                <a href="dashboard.php" class="back">Back</a>
                <p><?php echo $error_message; ?></p>
                <?php if ($userInfo) { ?>
                    <table border="1">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Firstname</th>
                                <th>Age</th>
                                <th>Bus ID</th>
                                <th>Route ID</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><?php echo $userInfo['id']; ?></td>
                                <td><?php echo $userInfo['firstname']; ?></td>
                                <td><?php echo $userInfo['age']; ?></td>
                                <td><?php echo $userInfo['busID']; ?></td>
                                <td><?php echo $userInfo['routeID']; ?></td>
                            </tr>
                        </tbody>
                    </table>
                <?php } ?>
            </form>
        </div>
    </div>
</body>

</html>
