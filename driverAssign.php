<?php
include("config.php");
include("headerAdmin.php");
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Bus Information</title>
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
            height: 55vh;
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

        .button {
            margin-top: 20px;
            width: 30%;
            padding: 5px;
            border-radius: 5px;
            transition: ease-in-out 0.2s;
            margin-bottom: 10px;
        }

        .button:hover {
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

        .form {
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

            <h2>Add Bus Information</h2>
            <hr class="hori">
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <label for="busID"></label><br>
                <input type="number" id="busID" name="busID" required placeholder="Bus ID"><br>

                <label for="route"></label><br>
                <input type="text" id="route" name="route" required placeholder="Route ID"><br>

                <label for="passengerCapacity"></label><br>
                <input type="number" id="passengerCapacity" name="passengerCapacity" required placeholder="Passenger Capacity"><br>

                <input type="submit" value="Submit" class="button"><br>
                <a href="dashboardAdmin" class="back">Back</a>
            </form>

        </div>
    </div>
    <?php
    // Include the database configuration file
    require_once "config.php";

    // Define variables and initialize with empty values
    $busID = $route = $passengerCapacity = "";

    // Processing form data when form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Validate Bus ID
        $busID = intval($_POST["busID"]);

        // Validate Route
        $route = trim($_POST["route"]);

        // Validate Passenger Capacity
        $passengerCapacity = intval($_POST["passengerCapacity"]);

        // Prepare an insert statement
        $sql = "INSERT INTO bus (busID, route, passengerCapacity) VALUES (?, ?, ?)";

        if ($stmt = mysqli_prepare($conn, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "iss", $busID, $route, $passengerCapacity);

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                // Redirect to success page
                echo 'Assigned Successfully';
            } else {
                echo '<script>alert("Error the Bus ID must start at 101!")';
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }

        // Close connection
        mysqli_close($conn);
    }
    ?>
</body>

</html>