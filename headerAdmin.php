<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <style>
        * {
            margin: 0;
            padding: 0;
        }

        nav {
            background-color: #bfbfbf;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 2px 2px 5px black inset, 2px 2px 10px inset black;
        }

        img {
            display: inline-block;
            margin-left: 70px;
            font-size: 30px;
        }



        nav ul li {
            display: inline-block;

        }

        nav .btn-admin {
            margin-right: 70px;
            text-decoration: none;
            color: black;
            font-size: 18px;
        }

        nav .btn-admin:hover {
            text-decoration: underline red;
        }

        ul li .active {
            margin-right: 70px;
            text-decoration: none;
            color: black;
            font-size: 18px;
            text-decoration: underline red;
        }

        .logout {
            margin-right: 70px;
            text-decoration: none;
            color: black;
            font-size: 18px;
            border-radius: 5px;
            transition: ease-in-out 0.2s;
        }

        .logout:hover {
            padding: 10px;
            background-color: red;
        }

        .dropdown {
            position: relative;
            display: inline-block;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #f9f9f9;
            min-width: 160px;
            z-index: 1;
            box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
        }

        .dropdown:hover .dropdown-content {
            display: block;
        }

        .dropdown-content a {
            color: black;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
        }

        .dropdown-content a:hover {
            background-color: #f1f1f1;
        }

        p {
            color: black;
            font-size: 18px;
            margin-right: 70px;
        }
    </style>
    <nav>
        <a href="dashboardAdmin.php" class="logo"><img src="images/logo.png" width="100" alt="Error Undifined Photo!"></a>
        <ul>
            <li><a href="dashboardAdmin.php" class="active">Home</a></li>
            <div class="dropdown">
                <p>Edit Schedule</h2>
                <div class="dropdown-content">
                    <a href="updateadmin.php">Update Information</a>
                    <a href="driverAssign.php">Assign Schedule</a>
                    <a href="detailsAdmin.php">Route Category</a>
                    <a href="createRoute.php">Create Route</a>


                </div>
            </div>  
            <li><a href="passengerDetails.php" class="btn-admin">Driver's Duty</a></li>
            <a href="logInadmin.php" class="logout">Logout</a>

        </ul>
    </nav>

</body>

</html>