<?php
include("config.php");
include("header.php");

// Initialize search variable
$searchRouteID = "";

// Process search query
if (isset($_GET['search'])) {
    $searchRouteID = $_GET['routeID'];
    $searchRouteID = mysqli_real_escape_string($conn, $searchRouteID);
    $sql = "SELECT * FROM route WHERE routeID LIKE '%$searchRouteID%'";
    $result = mysqli_query($conn, $sql);
} else {
    // Fetch all data from route table if no search query
    $sql = "SELECT * FROM route";
    $result = mysqli_query($conn, $sql);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Route Data</title>
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

        h1 {
            text-align: center;
            margin-top: 100px;
            font-weight: 900;
            font-family: sans-serif;
            font-size: 50px;
            color: white;
        }

        input {
            padding: 5px;
            border-radius: 5px;
        }

        button {
            padding: 5px;
            border-radius: 5px;
            width: 80px;
            transition: ease-in-out 0.2s;
        }

        button:hover {
            background-color: #80bfff;
        }
        .back{
            color: white;
            float: right;
            margin-top: -20px;
            font-size: 20px;
        }
        .back:hover{
            color: red;
        }
    </style>
</head>

<body>
    <h1>Driver's Schedule</h1>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="GET">
        <label for="routeID"></label>
        <button type="submit" name="search" class="">Search</button>
        <input type="text" id="routeID" name="routeID" value="<?php echo $searchRouteID; ?>" placeholder="Enter Route ID" class="">
    </form>

    <table>
        <thead>
            <tr>
                <th>Route ID</th>
                <th>Route From</th>
                <th>Route To</th>
                <th>Time</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . $row["routeID"] . "</td>";
                    echo "<td>" . $row["routeFrom"] . "</td>";
                    echo "<td>" . $row["routeTo"] . "</td>";
                    echo "<td>" . $row["oras"] . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='4'>No routes found.</td></tr>";
            }
            mysqli_close($conn);
            ?>
        </tbody>
    </table>
</body>
<a href="dashboard.php" class="back">Back</a>
</html>