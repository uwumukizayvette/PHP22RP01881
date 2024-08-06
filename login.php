<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "studentmanagement";
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = "SELECT * FROM users WHERE username='$username'";
    $result = mysqli_query($conn, $query);
    $user = mysqli_fetch_assoc($result);

    if ($user && $user['password']) {
        $_SESSION['user_id'] = $user['id'];
        header("Location: dashbord.php");
    } else {
        echo "Invalid username or password.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    
</head>
<body>
    <form method="POST" action="">
        <h2>LOGIN FORM</h2>
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required><br>
        
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br>
        
        <button type="submit">Login</button>
         <p>Don't have an account? <a href="regster.php">Create one here</a>.</p>
    </form>
   
</body>
</html>
