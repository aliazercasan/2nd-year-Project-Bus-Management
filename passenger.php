<?php
session_start();
include("header.php");
require_once "config.php";

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Initialize variables for form inputs and user information
$routeFrom = "";
$routeTo = "";
$totalPassenger = "";
$passengerCapacity = "";
$routeTimeDate = "";
$error = "";

// Handle form submission to search for bus route information
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['search'])) {
    $busID = trim($_POST['busID']);
    $totalPassenger = trim($_POST['totalPassenger']);

    // Validate busID
    if (!empty($busID) && is_numeric($busID)) {
        // Retrieve bus route information from the database based on the busID
        $stmt = $conn->prepare("SELECT routeFrom, routeTo, passengerTotal, passengerCapacity, routeTimeDate 
                                FROM bus 
                                JOIN route ON bus.route = route.routeID 
                                WHERE busID = ?");
        $stmt->bind_param("s", $busID);
        $stmt->execute();
        $result = $stmt->get_result();
        $busData = $result->fetch_assoc();

        // If bus data exists, assign it to variables
        if ($busData) {
            $routeFrom = $busData['routeFrom'];
            $routeTo = $busData['routeTo'];
            $passengerCapacity = $busData['passengerCapacity'];
            $routeTimeDate = $busData['routeTimeDate'];

            // Check if passengerTotal exceeds passengerCapacity
            if ($totalPassenger > $passengerCapacity) {
                echo '<script>alert("Passenger total cannot exceed passenger capacity.")</script>';
            } else {
                // Update the database with the new total passenger count
                $stmt = $conn->prepare("UPDATE bus SET passengerTotal = ? WHERE busID = ?");
                $stmt->bind_param("ii", $totalPassenger, $busID);
                $stmt->execute();
                $stmt->close();
            }
        } else {
            echo '<script>alert("Your Bus Id is not exist in our database! Just wait for the approval of the Admin!")</script>';
        }
    } else {
        echo '<script>alert("Invalid")</script>';
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bus Route Information</title>
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
            height: 46vh;
        }

        .hori {
            width: 70%;
            margin-left: 50px;
            margin-top: 5px;
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
        }

        button:hover {
            background-color: #80bfff;
        }

        h2 {
            margin-top: 5px;
            letter-spacing: 1px;
        }

        .result {
            background: linear-gradient(135deg, rgba(225, 225, 225, 0.1), rgba(225, 225, 225, 0));
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            width: 300px;
            padding: 10px;
            border-radius: 10px;
            box-shadow: 3px 3px 1px black inset, 2px 2px 1px black inset, 2px 2px 1px black inset, 2px 2px 10px black inset;
            border: 1px solid white;
            margin-left: -10px;
            margin-top: 30px;
        }

        .horizontal {
            width: 100%;
        }

        p {
            padding: 5px;
        }

        .success {
            letter-spacing: 2px;
            color: #80bfff;
        }

        .error {
            color: red;
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
            <h2 class="report">Report Your Route Today</h2>
            <hr class="hori">
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <label for="busID"></label><br>
                <input type="number" id="busID" name="busID" value="<?php echo $busID; ?>" required placeholder="Bus ID"><br>
                <label for="totalPassenger"></label><br>
                <input type="text" id="totalPassenger" name="totalPassenger" value="<?php echo $totalPassenger; ?>" required placeholder="Total Passenger"><br>
                <button type="submit" name="search">Submit</button><br>
                <a href="dashboard.php" class="back">Back</a>
            </form>
            <?php if (!empty($error)) { ?>
                <p class="error"><?php echo $error; ?></p>
            <?php } elseif ($routeFrom !== "" && $routeTo !== "") { ?>
                <div class="result">
                    <h2 class="success">Submitted Successfully</h2>
                    <p><strong>Route From:</strong> <?php echo $routeFrom; ?></p>
                    <hr>
                    <p><strong>Route To:</strong> <?php echo $routeTo; ?></p>
                    <hr class="horizontal">
                    <p><strong>Total Passengers:</strong> <?php echo $totalPassenger; ?></p>
                    <hr class="horizontal">
                    <p><strong>Passenger Capacity:</strong> <?php echo $passengerCapacity; ?></p>
                    <hr class="horizontal">
                    <p><strong>Route Time Date:</strong> <?php echo $routeTimeDate; ?></p>
                </div>
            <?php } ?>
        </div>
    </div>
</body>

</html>