<?php
include("config.php");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle registration form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['register'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Check if the username already exists
    $stmt = $conn->prepare("SELECT id FROM theadmin WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();
    
    if ($stmt->num_rows > 0) {
        echo '<script>alert("Username already exists. Please choose a different one.")</script>';
    } else {
        // Hash the password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Insert new user into the database
        $stmt = $conn->prepare("INSERT INTO theadmin (username, password) VALUES (?, ?)");
        $stmt->bind_param("ss", $username, $hashed_password);
        if ($stmt->execute()) {
            echo '<script>alert("Registration successful. You can now login.")</script>';
        } else {
            echo '<script>alert("Registration failed. Please try again later.")</script>';
        }
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Registration</title>
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
            margin-bottom: 15px;
        }

        div hr {
            margin-bottom: 10px;
            color: black;
            width: 70%;
            text-align: center;
            margin-left: 45px;
        }

        div input {
            width: 70%;
            padding: 5px;
            border-radius: 5px;
        }

        div button {
            width: 30%;
            padding: 5px;
            border-radius: 5px;
            margin-bottom: 10px;
            cursor: pointer;
            transition: ease-in-out 0.2s;
        }
        h2{
            font-size: 30px;
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
      
        .back{
            color: black;
            float: right;
            font-size: 18px;
            float: left;
            margin-left: 20px;
        }
        .back:hover{
            color: red;
        }
    </style>
</head>
<body>
    <div>
        <h2>Create Account</h2>
        <hr>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <label for="username"></label><br>
            <input type="text" id="username" name="username" required placeholder="Username"><br>
            <label for="password"></label><br>
            <input type="password" id="password" name="password" required placeholder="Password"><br><br>
            <button type="submit" name="register">Register</button><br>
            <a href="logInadmin.php" class="back">Back</a>
        </form>
    </div>
</body>
</html>
