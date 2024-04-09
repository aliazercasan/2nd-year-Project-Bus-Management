<?php
session_start();
include("headerAdmin.php");
require_once "config.php";

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Function to update user to not available
function updateUserToNotAvailable($userId, $conn)
{
    $stmt = $conn->prepare("UPDATE users SET username = 'This Driver is not available now', password = 0, id = 0 WHERE id = ?");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $stmt->close();
}

// Retrieve user information along with the route and passengerCapacity information from the bus table
$stmt = $conn->prepare("SELECT u.id, u.firstname,u.lastname,u.age,u.contactNumber,u.address,u.username,u.email,u.busID, b.route AS route, b.passengerCapacity AS passengerCapacity 
                        FROM users u 
                        LEFT JOIN bus b ON u.busID = b.busID");
$stmt->execute();
$result = $stmt->get_result();

// Close the statement
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <style>
        table {
            width: 100%;
            border: none;
            padding: 30px;
        }

        .driver {
            margin-top: 90px;
            color: white;
            letter-spacing: 1px;
            font-weight: 900;
            font-size: 50px;
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

        body {
            background: radial-gradient(rgba(0, 0, 0, 0.8), rgba(0, 0, 0, 0.7)), url(images/adminback.jpg) no-repeat;
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            text-align: center;
        }

        .search {
            float: right;
            margin-right: 60px;
            width: 5%;
            padding: 5px;
            border-radius: 5px;
            transition: ease-in-out 0.2s;
        }

        .button {
            width: 10%;
            padding: 10px;
            border-radius: 5px;
            transition: ease-in-out 0.2s;
        }

        .button:hover {
            background-color: #80bfff;
        }

        .search:hover {
            background-color: #80bfff;
        }

        .profile {
            display: flex;
            color: white;
        }

        .profile {
            float: right;
            margin-top: -70px;
        }

        .Id {
            font-size: 20px;
            margin-left: 10px;
            margin-right: 20px;
            margin-top: 5px;
        }

        .logo-driver {
            margin-top: -5px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1 class="driver">Driver's Schedules</h1>
        <table border="1">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Age</th>
                    <th>Contact Number</th>
                    <th>Address</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Bus ID</th>
                    <th>Route</th>
                    <th>Bus Capacity</th>
                    <th>Action</th> <!-- New column for delete button -->
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['firstname']; ?></td>
                        <td><?php echo $row['lastname']; ?></td>
                        <td><?php echo $row['age']; ?></td>
                        <td><?php echo $row['contactNumber']; ?></td>
                        <td><?php echo $row['address']; ?></td>
                        <td><?php echo $row['username']; ?></td>
                        <td><?php echo $row['email']; ?></td>
                        <td><?php echo $row['busID']; ?></td>
                        <td><?php echo $row['route']; ?></td>
                        <td><?php echo $row['passengerCapacity']; ?></td>
                        <td>
                            <form method="post" onsubmit="return confirm('Are you sure you want to delete this driver?');">
                                <input type="hidden" name="user_id" value="<?php echo $row['id']; ?>">
                                <button type="submit" name="delete">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</body>

</html>

<?php
// Check if delete request is sent
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete'])) {
    $userId = $_POST['user_id'];
    updateUserToNotAvailable($userId, $conn);
}
?>
