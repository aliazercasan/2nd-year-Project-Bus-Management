
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
            box-shadow: 2px 2px 5px black inset,2px 2px 10px inset black;
        }

        .logo {
            display: inline-block;
            margin-left: 70px;
            font-size: 30px;
        }

        nav ul li {
            display: inline-block;

        }

        a {
            margin-right: 50px;
            text-decoration: none;
            color: black;
            font-size: 18px;
        }

        .active {
            font-weight: 500;
            text-decoration: underline red;
        }

        .logout {
            text-decoration: none;
            color: black;
            font-size: 18px;
            transition: ease-in-out 0.2s;
        }
        .logout:hover{
            background-color: red;
            padding: 10px;
            border-radius: 5px;
        }

      
        .btn:hover{
            text-decoration: underline red;
        }
    </style>
    <nav>
        <a href="dashboard.php" class="logo"><img src="images/logo.png" width="100" alt="Error Undifined Photo!"></a>
        <ul>
            <li><a href="dashboard.php" class="active">Home</a></li>
            <li><a href="about.php" class="btn">About</a></li>
            <li><a href="historyRoute.php" class="btn">History Route</a></li>
            <li><a href="leave.php" class="btn">Leave</a></li>
            <a href="login.php" class="logout">Logout</a>
        </ul>

    </nav>

</body>

</html>