<?php
session_start();
include("header.php");
require_once "config.php";

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Retrieve user ID from session
$user_id = $_SESSION['user_id'];

// Retrieve user information along with the route and passengerCapacity information from the bus table
$stmt = $conn->prepare("SELECT u.id, u.firstname, u.age, u.busID, b.route AS route, b.passengerCapacity AS passengerCapacity 
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
        table{
            width: 100%;
            border: none;
            padding: 30px;
        }
        .driver{
            margin-top: 90px;
            color: white;
            letter-spacing: 1px;
            font-weight: 900;
            font-size: 50px;
        }
        
        th{
            padding: 10px;
            background-color:#ff6666 ;
            font-weight: 900;
            font-size: 20px;
        }
        td{
            padding: 5px;
            background-color:  #999999;
            font-size: 20px;
        }
        body{
            background: radial-gradient(rgba(0, 0, 0, 0.8), rgba(0, 0, 0, 0.7)),url(images/background2.jpg) no-repeat;
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            text-align: center;
        }
        .search{
            float: right;
            margin-right: 60px;
            width: 5%;
            padding: 5px;
            border-radius: 5px;
            transition: ease-in-out 0.2s;
        }
        .button{
            width: 10%;
            padding: 10px;
            border-radius: 5px;
            transition: ease-in-out 0.2s;
        }
        .button:hover{
            background-color: #80bfff;
        }
        .search:hover{
            background-color: #80bfff;

        }
       .profile{
        display: flex;
        color: white;

       }
       .profile{
        float: right;
        margin-top: -70px;
       }
       .Id{
        font-size: 20px;
        margin-left: 10px;
        margin-right: 20px;
        margin-top: 5px;
       }
       .logo-driver{
        margin-top: -5px;
    }
    </style>
</head>

<body>
    <div class="container">

        <div class="profile">
            <img src="images/taxi-driver.png" alt="404 Critical Power Ranger" width="40" class="logo-driver">
            <h1 class="Id">Driver ID : <?php echo $user_id; ?></h1> 
        </div>

        <h1 class="driver">Driver's Schedules</h1>
        <a href="search.php"><button class="search">Search</button></a>
        <table border="1">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>First Name</th>
                    <th>Age</th>
                    <th>Bus ID</th>
                    <th>Route</th> 
                    <th>Passenger Capacity</th> 
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['firstname']; ?></td>
                        <td><?php echo $row['age']; ?></td>
                        <td><?php echo $row['busID']; ?></td>
                        <td><?php echo $row['route']; ?></td> 
                        <td><?php echo $row['passengerCapacity']; ?></td> 
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        <a href="passenger.php"><button class="button">Report Route</button></a>
        <a href="details.php"><button class="button">Category Route</button></a>
    </div>
</body>

</html>
