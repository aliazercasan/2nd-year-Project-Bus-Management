<?php
session_start();
include("headerUser.php");
require_once "config.php";

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Define variables to store user inputs and error messages
$routeFrom = $routeTo = "";
$routeFromErr = $routeToErr = "";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate routeFrom
    if (empty($_POST["routeFrom"])) {
        $routeFromErr = "Route From is required";
    } else {
        $routeFrom = $_POST["routeFrom"];
    }

    // Validate routeTo
    if (empty($_POST["routeTo"])) {
        $routeToErr = "Route To is required";
    } else {
        $routeTo = $_POST["routeTo"];
    }
}

// Retrieve data from the route table based on search criteria
$stmt = $conn->prepare("SELECT routeID, routeFrom, routeTo, oras FROM route WHERE routeFrom LIKE ? AND routeTo LIKE ?");
$routeFromSearch = '%' . $routeFrom . '%';
$routeToSearch = '%' . $routeTo . '%';
$stmt->bind_param("ss", $routeFromSearch, $routeToSearch);
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
    <title>Route Data</title>
    <style>
        table{
            width: 1200px;
            border: none;
            padding: 30px;
            margin-left: -450px;
            margin-top: 70px;
        }
        th{
            padding: 20px;
            background-color:#ff6666 ;
            font-weight: 900;
            font-size: 20px;
        }
        td{
            padding: 10px;
            background-color:  #999999;
            font-size: 20px;
        }
        body{
            background: radial-gradient(rgba(0, 0, 0, 0.8), rgba(0, 0, 0, 0.7)),url(images/background2.jpg) no-repeat;
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            text-align: center;
            color: white;
        }
        h2{
            color: white;
        }
        input{
            padding: 5px;
            border-radius: 5px;
        }
        div {
            background: linear-gradient(135deg, rgba(225, 225, 225, 0.1), rgba(225, 225, 225, 0));
            backdrop-filter: blur(5px);
            -webkit-backdrop-filter: blur(5px);
            width: 300px;
            height: 210px;
            border-radius: 10px;
            margin-left: 620px;
            padding: 10px;
            border: 2px solid red;
            margin-top: 120px;
        }
        .back{
            color: white;
            float: right;
            font-size: 20px;
            float: left;
            margin-top: 10px;
            margin-left: 15px;
        }
        .back:hover{
            color: red;
        }
        .btn{
            padding: 5px;
            border-radius: 5px;
            width: 80px;
            transition: ease-in-out 0.2s;
            margin-top: 10px;
        }
        .btn:hover{
            background-color: #80bfff;
            text-decoration: none;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Search Routes</h1>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <label for="routeFrom"></label><br>
            <input type="text" id="routeFrom" name="routeFrom" value="<?php echo htmlspecialchars($routeFrom); ?>" placeholder="Route From">
            <span class="error"><?php echo $routeFromErr; ?></span><br>

            <label for="routeTo"></label><br>
            <input type="text" id="routeTo" name="routeTo" value="<?php echo htmlspecialchars($routeTo); ?>" placeholder="Route To">
            <span class="error"><?php echo $routeToErr; ?></span><br>

            <input type="submit" value="Search" class="btn"><br>
            <a href="user.php" class="back">Back</a>
        </form>
        <table>
            <thead>
                <tr>
                    <th>Route ID</th>
                    <th>Route From</th>
                    <th>Route To</th>
                    <th>Oras</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo $row['routeID']; ?></td>
                        <td><?php echo $row['routeFrom']; ?></td>
                        <td><?php echo $row['routeTo']; ?></td>
                        <td><?php echo $row['oras']; ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</body>

</html>
