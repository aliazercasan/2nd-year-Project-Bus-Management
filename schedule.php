<?php
session_start();
include("header.php");
require_once "config.php";

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Define variables for search
$search_username = "";

// Handle search form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['search'])) {
    // Retrieve and sanitize search criteria
    $search_username = mysqli_real_escape_string($conn, $_POST['search_username']);

    // Perform search query
    $stmt = $conn->prepare("SELECT id, firstname, lastname, age, address, routeFrom, routeTo,oras, busId FROM users WHERE username LIKE ?");
    $search_param = "%{$search_username}%";
    $stmt->bind_param("s", $search_param);
    $stmt->execute();
    $result = $stmt->get_result();
    $users = $result->fetch_all(MYSQLI_ASSOC);

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Search</title>
    <style>
        * {
            margin: 0;
            padding: 0;
        }

        body {
            background: radial-gradient(rgba(0, 0, 0, 0.8), rgba(0, 0, 0, 0.7)), url(images/background2.jpg) no-repeat;
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
        }

        h1 {
            color: white;
        }

        form {
            color: white;
        }

        div {
            text-align: center;
            background-color: #404040;
            display: inline-block;
            margin-left: 660px;
            margin-top: 100px;
            padding: 20px;
            border-radius: 10px;
            width: 200px;
        }

        input {
            padding: 5px;
            border-radius: 5px;
            outline: none;
            border: none;
            margin-top: 10px;
        }

        form .search {
            margin-top: 10px;
            width: 80px;
            padding: 5px;
            border-radius: 5px;
            cursor: pointer;
            margin-bottom: 15px;
            transition: ease-in-out 0.2s;
        }

        form .search:hover{
            background-color: #80bfff;
        }

        form .btn-back {
            font-size: 16px;
            margin-left: -120px;
            padding: 5px;
            color: white;
            transition: ease-in-out 0.2s;
        }
        form .btn-back:hover{
            color: red;
        }

        table {
            width: 70%;
            margin-left: 250px;
            margin-bottom: 40px;
            background-color: #4d4d4d;
            border-radius: 10px;
            text-align: center;
        }

        h2 {
            text-align: center;
            color: white;
            margin-top: 20px;
            margin-bottom: 20px;
        }

        th {
            padding: 10px;
            color: #e6e6e6;

        }
        td {
        padding: 5px;
        color: white;
    }
    </style>
</head>

<body>
    <div>

        <h1>Search</h1>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <label for="search_username"></label>
            <input type="text" id="search_username" name="search_username" value="<?php echo $search_username; ?>" required placeholder="Search Username"><br>
            <button class="search" type="submit" name="search">Search</button><br>
            <a href="dashboard.php" class="btn-back">Back</a>
    </div>
    </form>
    <?php if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['search'])) { ?>
        <h2>Search Result</h2>
        <?php if (count($users) > 0) { ?>
            <table border="1">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Age</th>
                        <th>Address</th>
                        <th>Route From</th>
                        <th>Route To</th>
                        <th>Time</th>
                        <th>Bus Id</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user) { ?>
                        <tr>
                            <td><?php echo $user['id']; ?></td>
                            <td><?php echo $user['firstname']; ?></td>
                            <td><?php echo $user['lastname']; ?></td>
                            <td><?php echo $user['age']; ?></td>
                            <td><?php echo $user['address']; ?></td>
                            <td><?php echo $user['routeFrom']; ?></td>
                            <td><?php echo $user['routeTo']; ?></td>
                            <td><?php echo $user['oras']; ?></td>
                            <td><?php echo $user['busId']; ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        <?php } else { ?>
            <p>No users found.</p>
        <?php } ?>
    <?php } ?>
</body>

</html>