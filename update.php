<?php
session_start();
include('conn.php');

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Validate and sanitize the ID
if (!isset($_GET['id']) || !filter_var($_GET['id'], FILTER_VALIDATE_INT)) {
    die("Invalid ID.");
}

$student_id = intval($_GET['id']); // Convert to integer

// Fetch the student data with a prepared statement
$stmt = $conn->prepare("SELECT * FROM student WHERE id = ?");
$stmt->bind_param("i", $student_id);
$stmt->execute();
$result = $stmt->get_result();
$student = $result->fetch_assoc();

if (!$student) {
    die("Student not found.");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize input data
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
        // Update student data with a prepared statement
        $stmt = $conn->prepare("UPDATE student SET fname = ?, lname = ?, email = ?, phone = ?, address = ? WHERE id = ?");
        $stmt->bind_param("sssssi", $fname, $lname, $email, $phone, $address, $student_id);

        if ($stmt->execute()) {
            echo "Student updated successfully. <a href='select.php'>Select Student</a>";
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
    <title>Update Student</title>
    <style>
        .error {
            color: red;
        }
    </style>
</head>
<body>
    <form method="POST" action="">
        <h2>Update Student</h2>
        <label for="fname">First Name:</label>
        <input type="text" id="fname" name="fname" value="<?php echo htmlspecialchars($student['fname']); ?>" required><br>
        
        <label for="lname">Last Name:</label>
        <input type="text" id="lname" name="lname" value="<?php echo htmlspecialchars($student['lname']); ?>" required><br>
        
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($student['email']); ?>" required><br>
        
        <label for="phone">Phone:</label>
        <input type="text" id="phone" name="phone" value="<?php echo htmlspecialchars($student['phone']); ?>" required pattern="\d{10}" title="Phone number must be 10 digits"><br>
        
        <label for="address">Address:</label>
        <input type="text" id="address" name="address" value="<?php echo htmlspecialchars($student['address']); ?>" required><br>
        
        <button type="submit">Update Student</button>
    </form>
</body>
</html>
