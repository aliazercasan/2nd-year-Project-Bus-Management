<?php
include("config.php");

// Handle login form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Retrieve user from the database
    $stmt = $conn->prepare("SELECT id, username, password FROM theadmin WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    // Verify password
    if ($user && password_verify($password, $user['password'])) {
        // Login successful
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        header("Location:dashboardAdmin.php");
        exit();
    } else {
        echo'<script>alert("Incorrect Username or Password...Please try again!")</script>';
    }

    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Log In</title>
    <style>
        *{
            padding: 0;
            margin: 0;
        }
        body{
            background: radial-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), url(images/admin.jpg) no-repeat;
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            text-align: center;
            display: flex;
            justify-content: center;
            height: 100vh;
        }
        div{
            width: 300px;
            height: 250px;
            border-radius: 10px;
            margin-top: 190px;
            padding: 10px;
            border: 2px solid red;
            background-color: #bfbfbf;
        }
        form {
            text-align: center;
        }

        div h2 {
            text-align: center;
            margin-bottom: 10px;
        }

        div hr {
            margin-bottom: 10px;
            color: black;
            width: 70%;
            text-align: center;
            margin-left: 45px;
        }

        div input {
            margin-top: 10px;
            width: 70%;
            padding: 5px;
            border-radius: 5px;
        }

        div button {
            margin-top: 20px;
            width: 20%;
            padding: 5px;
            border-radius: 5px;
            margin-bottom: 10px;
            cursor: pointer;
            transition: ease-in-out 0.2s;
        }
        h2{
            font-size: 20px;
            margin-top: 10px;
        }
        button:hover{
            background-color:  #80bfff;
        }
        a{
            text-decoration: none;
            color: darkblue;
        }
        a:hover{
            color: blue;
        }
    </style>
</head>
<body>
    <div>
    <h1>Admin</h1>
    <h2>Log In</h2>
    <hr>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <label for="username"></label>
            <input type="text" id="username" name="username" required placeholder="Username"><br>
            <label for="password"></label>
            <input type="password" id="password" name="password" required placeholder="Password"><br>
            <button type="submit" name="login">Login</button>
            <p>Don't have an account? <a href="createAdmin.php">Create</a></p>
        </form>

    </div>
</body>
</html>