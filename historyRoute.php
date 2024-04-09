<?php
// Include the configuration file
require_once "config.php";
include("header.php");

// Initialize an empty array to store the fetched records
$busData = [];

// Check if the search form is submitted
if(isset($_POST['search'])) {
    $searchedBusID = $_POST['busID'];
    // Query to fetch record with the given busID
    $sql = "SELECT busID, route, passengerTotal, passengerCapacity, routeTimeDate FROM bus WHERE busID = '$searchedBusID'";
} else {
    // Query to fetch all records from the bus table
    $sql = "SELECT busID, route, passengerTotal, passengerCapacity, routeTimeDate FROM bus";
}

$result = mysqli_query($conn, $sql);

// Check if the query was successful
if ($result) {
    // Fetch each row and store it in the $busData array
    while ($row = mysqli_fetch_assoc($result)) {
        $busData[] = $row;
    }
}

// Close the database connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bus Data</title>
    <style>
            body {
            background: radial-gradient(rgba(0, 0, 0, 0.8), rgba(0, 0, 0, 0.7)), url(images/background2.jpg) no-repeat;
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
        }

        th {
            padding: 10px;
            background-color: #ff6666;
            font-weight: 900;
            font-size: 20px;
            color: black;
        }

        td {
            padding: 5px;
            background-color: #999999;
            font-size: 20px;
            color: black;
            text-align: center;

        }

        table {
            width: 100%;
            border: none;
            padding: 30px;
        }

        input {
            float: right;
            margin-top: 20px;
            margin-bottom: -20px;
        }

        button {
            float: right;
            margin-top: 20px;
            margin-bottom: -20px;
            margin-right: 50px;
        }

        h2 {
            text-align: center;
            margin-top: 80px;
            font-weight: 900;
            font-family: sans-serif;
            font-size: 50px;
            color: white;
        }

        input {
            padding: 5px;
            border-radius: 5px;
        }

       .button {
            padding: 5px;
            border-radius: 5px;
            width: 80px;
            margin-right: 30px;
            transition: ease-in-out 0.2s;
        }

        .button:hover {
            background-color: #80bfff;
        }
    </style>
</head>
<body>
    <h2>Bus Data</h2>
    <!-- Search form -->
    <form method="POST" action="">
        <label for="busID">Enter Bus ID:</label>
        <input type="submit" name="search" value="Search" class="button">
        <input type="text" id="busID" name="busID" placeholder="Enter Bus ID">
    </form>
    <table border="1">
        <thead>
            <tr>
                <th>Bus ID</th>
                <th>Route</th>
                <th>Passenger Total</th>
                <th>Passenger Capacity</th>
                <th>Route Time Date</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($busData as $bus) { ?>
                <tr>
                    <td><?php echo $bus['busID']; ?></td>
                    <td><?php echo $bus['route']; ?></td>
                    <td><?php echo $bus['passengerTotal']; ?></td>
                    <td><?php echo $bus['passengerCapacity']; ?></td>
                    <td><?php echo $bus['routeTimeDate']; ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</body>
</html>
