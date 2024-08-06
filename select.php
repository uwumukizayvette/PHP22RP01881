<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Student Management Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 80%;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        h1 {
            color: #333;
        }
        a {
            display: inline-block;
            margin: 10px;
            padding: 10px 20px;
            color: #fff;
            background-color: #007bff;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s;
        }
        a:hover {
            background-color: #0056b3;
        }
        .welcome-message {
            font-size: 1.2em;
            color: #333;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="welcome-message">
            <?php echo "Welcome to the Student Management"; ?>
        </div>
        <div>
            <a href="insert.php">Insert Student</a>
            <a href="select.php">View Student</a>
            <a href="logout.php">Logout</a>
        </div>
    </div>
</body>
</html>

<?php

include('conn.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$query = "SELECT * FROM student";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html>
<head>
    
    <title>View Students</title>
</head>
<body>
    <center>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Address</th>
            <th>Actions</th>
        </tr>
        <?php 
        while ($student = mysqli_fetch_assoc($result)) { ?>
        <tr>
            <td><?php echo $student['id']; ?></td>
            <td><?php echo $student['fname']; ?></td>
            <td><?php echo $student['lname']; ?></td>
            <td><?php echo $student['email']; ?></td>
            <td><?php echo $student['phone']; ?></td>
            <td><?php echo $student['address']; ?></td>
            <td>
                <a href="update.php?id=<?php echo $student['id']; ?>">Update</a>
                <a href="delete.php?id=<?php echo $student['id']; ?>">Delete</a>
            </td>
        </tr>
        <?php } ?>
    </table>
</center>
</body>
</html>
