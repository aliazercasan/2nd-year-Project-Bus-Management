<?php
// Include database configuration
include("config.php");

$message = ""; // Variable to store error/success message

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    // Sanitize input data
    $firstname = htmlspecialchars(trim($_POST['firstname']));
    $lastname = htmlspecialchars(trim($_POST['lastname']));
    $age = intval($_POST['age']);
    $contactNumber = htmlspecialchars(trim($_POST['contactNumber']));
    $address = htmlspecialchars(trim($_POST['address']));
    $username = htmlspecialchars(trim($_POST['username']));
    $password = $_POST['password'];
    $email = htmlspecialchars(trim($_POST['email'])); // Sanitize email

    // Check if the firstname already exists in the database
    $stmt_check = $conn->prepare("SELECT id FROM users WHERE firstname = ?");
    $stmt_check->bind_param("s", $firstname);
    if (!$stmt_check->execute()) {
        // Handle query execution error
        $message = "Error executing query: " . $stmt_check->error;
    } else {
        $result_check = $stmt_check->get_result();
        if ($result_check->num_rows > 0) {
            // Firstname already exists
            echo "<script>alert('Firstname already exists');</script>";

        } else {
            // Insert new user data into the database
            // Check if the email already exists
            $stmt_email_check = $conn->prepare("SELECT id FROM users WHERE email = ?");
            $stmt_email_check->bind_param("s", $email);
            if (!$stmt_email_check->execute()) {
                // Handle query execution error
                $message = "Error executing query: " . $stmt_email_check->error;
            } else {
                $result_email_check = $stmt_email_check->get_result();
                if ($result_email_check->num_rows > 0) {
                    // Email already exists
                    echo "<script>alert('Email already exists');</script>";
                } else {
                    // Insert new user data into the database
                    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                    $insert_stmt = $conn->prepare("INSERT INTO users (firstname, lastname, age, contactNumber, address, username, password, email) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
                    $insert_stmt->bind_param("ssisssss", $firstname, $lastname, $age, $contactNumber, $address, $username, $hashed_password, $email);
                    if ($insert_stmt->execute()) {
                        echo "<script>alert('Registered Successfully');</script>";
                    } else {
                        // Handle insertion error
                        if (strpos($insert_stmt->error, 'foreign key constraint fails') !== false) {
                            echo "<script>alert('Error creating account: One or more fields contain invalid data.');</script>";
                        } else {
                            $message = "Error creating account: " . $insert_stmt->error;
                        }
                    }
                    $insert_stmt->close(); // Close the insert statement
                }
            }
            $stmt_email_check->close(); // Close the email check statement
        }
    }
    $stmt_check->close(); // Close the select statement
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Registration</title>
    <style>
         
           * {
            padding: 0;
            margin: 0;
        }

        div {
            background: linear-gradient(135deg, rgba(225, 225, 225, 0.1), rgba(225, 225, 225, 0));
            backdrop-filter: blur(5px);
            -webkit-backdrop-filter: blur(5px);
            margin-top: 80px;
            width: 300px;
            height: 560px;
            border-radius: 10px;
            margin-left: 620px;
            padding: 10px;
            border: 2px solid red;
            color: white;
        }

        form {
            text-align: center;
        }

        div h1 {
            text-align: center;
            margin-bottom: 10px;
            letter-spacing: 1px;
            font-size: 30px;
            font-weight: 900;
            margin-top: 10px;
            letter-spacing: 2px;
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
            margin-top: 20px;
            width: 30%;
            padding: 5px;
            border-radius: 5px;
            margin-bottom: 20px;
            cursor: pointer;
            transition: ease-in-out 0.2s;
        }

        body {
            background: radial-gradient(rgba(0, 0, 0, 0.8), rgba(0, 0, 0, 0.7)),url(images/background2.jpg) no-repeat;
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
        }
        form a{
            text-decoration: none;
            color: black;
            transition:0.2s;
            color: white;
        }
        form a:hover{
            text-decoration: underline blue;
            color: blue;
        }
        form button:hover{
            background-color: #80bfff;
        }
    
    </style>
    </style>
</head>

<body>
<div>
        <h1>UniRide</h1>
        <hr>
        <h1 style="font-size: 20px; margin-bottom:-5px;">Create Account</h1>

        <?php if (!empty($message)) echo "<p>$message</p>"; ?>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <label for="firstname"></label><br>
            <input type="text" id="firstname" name="firstname" required placeholder="Firstname"><br>
            <label for="lastname"></label><br>
            <input type="text" id="lastname" name="lastname" required placeholder="Lastname"><br>
            <label for="age"></label><br>
            <input type="number" id="age" name="age" required placeholder="Age"><br>
            <label for="contactNumber"></label><br>
            <input type="number" id="contactNumber" name="contactNumber" required placeholder="Contact Number"><br>
            <label for="address"></label><br>
            <input type="text" id="address" name="address" required placeholder="Address"><br>
            <label for="username"></label><br>
            <input type="text" id="username" name="username" required placeholder="Username"><br>
            <label for="password"></label><br>
            <input type="password" id="password" name="password" required placeholder="Password"><br>
            <label for="email"></label><br> 
            <input type="email" id="email" name="email" required placeholder="Email"><br> 
            
            <button type="submit" name="submit">Register</button>
            <p>Already have an account? <a href="login.php">Sign In</a></p>
        </form>
    </div>
</body>

</html>
