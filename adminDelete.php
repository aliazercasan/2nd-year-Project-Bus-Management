<?php
require_once "config.php ";
include("headerAdmin.php");

// Check if the admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}

// Fetch all employees from the database
$sql = "SELECT * FROM employees";
$result = $conn->query($sql);

// Check if the form is submitted for deleting an employee
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete'])) {
    $employee_id = $_POST['employee_id'];
    $delete_query = "DELETE FROM employees WHERE id = $employee_id";
    if ($conn->query($delete_query) === TRUE) {
        echo "Employee deleted successfully.";
        // Refresh the page after deletion
        header("Refresh:0");
        exit();
    } else {
        echo "Error deleting employee: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Manage Employees</title>
</head>
<body>
    <h2>Manage Employees</h2>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Age</th>
            <th>Address</th>
            <th>Action</th>
        </tr>
        <?php
        // Display employees in a table
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['id'] . "</td>";
                echo "<td>" . $row['firstname'] . "</td>";
                echo "<td>" . $row['lastname'] . "</td>";
                echo "<td>" . $row['age'] . "</td>";
                echo "<td>" . $row['address'] . "</td>";
                echo "<td>";
                echo "<a href='edit_employee.php?id=" . $row['id'] . "'>Edit</a> | ";
                echo "<form action='" . htmlspecialchars($_SERVER["PHP_SELF"]) . "' method='post'>";
                echo "<input type='hidden' name='employee_id' value='" . $row['id'] . "'>";
                echo "<button type='submit' name='delete'>Delete</button>";
                echo "</form>";
                echo "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='6'>No employees found</td></tr>";
        }
        ?>
    </table>
    <a href="admin_dashboard.php">Back to Dashboard</a>
</body>
</html>
