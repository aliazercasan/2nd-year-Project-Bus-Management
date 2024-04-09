<?php
include("config.php");

// Start session
session_start();
$message='Incorrect Username or Password';
// Handle login form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Retrieve user from the database
    $stmt = $conn->prepare("SELECT id, username, password FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    // Verify password
    if ($user && password_verify($password, $user['password'])) {
        // Login successful
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        header("Location: dashboard.php");
        exit();
    } else {
        echo "<script>alert('$message');</script>";
    }

    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log In</title>

    <style>
        
        * {
            padding: 0;
            margin: 0;
        }

        div {
            background: linear-gradient(135deg, rgba(225, 225, 225, 0.1), rgba(225, 225, 225, 0));
            backdrop-filter: blur(5px);
            -webkit-backdrop-filter: blur(5px);
            width: 300px;
            height: 240px;
            border-radius: 10px;
            margin-left: 620px;
            padding: 10px;
            border: 2px solid red;
        }

        form {
            text-align: center;
        }

        div h2 {
            text-align: center;
            margin-bottom: 10px;
            letter-spacing: 1px;
            font-size: 30px;
            font-weight: 900;
            color: white;
        }

        div hr {
            margin-bottom: 10px;
            color:white;
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
            margin-bottom: 20px;
            cursor: pointer;
            transition: ease-in-out 0.2s;
        }

        body {
            display: flex;
            align-items: center;
            height: 90vh;
            background: radial-gradient(rgba(0, 0, 0, 0.8), rgba(0, 0, 0, 0.7)),url(images/background2.jpg) no-repeat;
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
        }
        form a{
            text-decoration: none;
            color: white;
            transition:0.2s;
        }
        form a:hover{
            text-decoration: underline blue;
            color: blue;
        }
        form button:hover{
            background-color: #80bfff;
        }
      p{
        color: white;
      }
    </style>
    </style>
</head>

<body>
    
    <div>
        <h2>Login</h2>
        <hr>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <label for="username"></label>
            <input type="text" id="username" name="username" required placeholder="Username"><br>
            <label for="password"></label>
            <input type="password" id="password" name="password" required placeholder="Password"><br>
            <button type="submit" name="login">Login</button>
            <p>Don't have an account? <a href="create.php">Register</a></p>
        </form>

    </div>
</body>

</html>
