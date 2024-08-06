<?php
session_start();
include('conn.php');

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Check if 'id' is set and is an integer
if (!isset($_GET['id']) || !filter_var($_GET['id'], FILTER_VALIDATE_INT)) {
    echo "Invalid ID.";
    exit();
}


$id = intval($_GET['id']); 

$stmt = $conn->prepare("DELETE FROM student WHERE id = ?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    echo "Student deleted successfully. <a href='select.php'>Select Student</a>";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
?>
