<?php
// Include the database configuration file
include("headerAdmin.php");
require_once "config.php";

// Define variables and initialize with empty values
$routeID = $routeFrom = $routeTo = $oras = "";
$routeID_err = $routeFrom_err = $routeTo_err = $oras_err = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate routeID
    $input_routeID = trim($_POST["routeID"]);
    if (empty($input_routeID)) {
        $routeID_err = "Please enter a route ID.";
    } else {
        $routeID = $input_routeID;
    }

    // Validate routeFrom
    $input_routeFrom = trim($_POST["routeFrom"]);
    if (empty($input_routeFrom)) {
        $routeFrom_err = "Please enter a route From.";
    } else {
        $routeFrom = $input_routeFrom;
    }

    // Validate routeTo
    $input_routeTo = trim($_POST["routeTo"]);
    if (empty($input_routeTo)) {
        $routeTo_err = "Please enter a route To.";
    } else {
        $routeTo = $input_routeTo;
    }

    // Validate oras
    $input_oras = trim($_POST["oras"]);
    if (empty($input_oras)) {
        $oras_err = "Please enter the time.";
    } else {
        $oras = $input_oras;
    }

    // Check input errors before inserting into database
    if (empty($routeID_err) && empty($routeFrom_err) && empty($routeTo_err) && empty($oras_err)) {
        // Prepare an insert statement
        $sql = "INSERT INTO route (routeID, routeFrom, routeTo, oras) VALUES (?, ?, ?, ?)";

        if ($stmt = $conn->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("ssss", $param_routeID, $param_routeFrom, $param_routeTo, $param_oras);

            // Set parameters
            $param_routeID = $routeID;
            $param_routeFrom = $routeFrom;
            $param_routeTo = $routeTo;
            $param_oras = $oras;

            // Attempt to execute the prepared statement
            if ($stmt->execute()) {
                // Records created successfully. Redirect to landing page
                echo "<script>alert('Route created successfully');</script>";
               
               
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            $stmt->close();
        }
    }

    // Close connection
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Route</title>
    <style>
        * {
            padding: 0;
            margin: 0;
        }

        body {
            background: radial-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), url(images/adminback.jpg) no-repeat;
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            text-align: center;
        }

        .wrapper {
            background: linear-gradient(135deg, rgba(225, 225, 225, 0.1), rgba(225, 225, 225, 0));
            backdrop-filter: blur(5px);
            -webkit-backdrop-filter: blur(5px);
            margin-top: 80px;
            width: 300px;
            border-radius: 10px;
            margin-left: 620px;
            padding: 10px;
            border: 2px solid red;
            color: white;
        }
        .form-control {
            width: 70%;
            padding: 10px;
            border-radius: 5px;
            margin-top: 10px;
        }
        hr{
            margin-top: 5px;
            margin-bottom: 10px;
        }
        .btn{
            margin-top: 20px;
            width: 30%;
            padding: 5px;
            border-radius: 5px;
            margin-bottom: 30px;
            cursor: pointer;
            transition: ease-in-out 0.2s;
        }
        .btn:hover{
            background-color: #80bfff;
        }
        .back{
            color: white;
            float: right;
            font-size: 18px;
            text-decoration: none;
            float: left;
            margin-top: -25px;
            margin-left: 15px;
        }
        .back:hover{
            color: red;
        }
        h2{
        font-size: 30px;
        margin-bottom: 10px;
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <h2>Add New Route</h2>
        <hr>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group <?php echo (!empty($routeID_err)) ? 'has-error' : ''; ?>">
                <label></label>
                <input type="text" name="routeID" class="form-control" value="<?php echo $routeID; ?>" placeholder="Route ID">
                <span class="error"><?php echo $routeID_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($routeFrom_err)) ? 'has-error' : ''; ?>">
                <label></label>
                <input type="text" name="routeFrom" class="form-control" value="<?php echo $routeFrom; ?>" placeholder="Route From">
                <span class="error"><?php echo $routeFrom_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($routeTo_err)) ? 'has-error' : ''; ?>">
                <label></label>
                <input type="text" name="routeTo" class="form-control" value="<?php echo $routeTo; ?>" placeholder="Route To">
                <span class="error"><?php echo $routeTo_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($oras_err)) ? 'has-error' : ''; ?>">
                <label></label>
                <input type="text" name="oras" class="form-control" value="<?php echo $oras; ?>" placeholder="Time">
                <span class="error"><?php echo $oras_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn" value="Submit"><br>
                <a href="dashboardAdmin.php" class="back">Back</a>
            </div>
        </form>
    </div>
</body>

</html>