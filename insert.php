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

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize and validate input data
    $fname = trim($_POST['fname']);
    $lname = trim($_POST['lname']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $address = trim($_POST['address']);

    $errors = [];

    // Validate input data
    if (empty($fname) || empty($lname) || empty($email) || empty($phone) || empty($address)) {
        $errors[] = "All fields are required.";
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format.";
    }

    if (!preg_match('/^\d{10}$/', $phone)) {
        $errors[] = "Phone number must be 10 digits.";
    }

    // Display errors if there are any
    if (!empty($errors)) {
        foreach ($errors as $error) {
            echo "<p class='error'>$error</p>";
        }
    } else {
        // Use prepared statements to prevent SQL injection
        $stmt = $conn->prepare("INSERT INTO student (fname, lname, email, phone, address) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $fname, $lname, $email, $phone, $address);

        if ($stmt->execute()) {
            echo "Student added successfully.";
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Insert Student</title>
    <style>
        .error {
            color: red;
        }
    </style>
</head>

<body>
    <center>
    <form method="POST" action="">
        <h2>Insert Student</h2>
        <label for="fname">First Name:</label><br>
        <input type="text" id="fname" name="fname" required><br>
        
        <label for="lname">Last Name:</label><br>
        <input type="text" id="lname" name="lname" required><br>
        
        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email" required><br>

        <label for="phone">Phone:</label><br>
        <input type="text" id="phone" name="phone" required pattern="\d{10}" title="Phone number must be 10 digits"><br>
        
        <label for="address">Address:</label><br>
        <input type="text" id="address" name="address" required><br><br>
        
        <button type="submit">Add Student</button>
    </form>
</center>
</body>
</html>
