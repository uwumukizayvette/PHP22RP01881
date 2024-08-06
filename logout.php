<?php
session_start();


if (isset($_POST['login'])) {
    
    $_SESSION['username'] = $_POST['username']; 
    header("Location: login.php"); 
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body>
    <h1>LOGIN FORM</h1>
<form action="" method="POST">
        Username: <input type="text" name="username" required><br>
        Password: <input type="password" name="password" required><br>
<input type="submit" name="login" value="Login">
</form>
</body>
</html>
