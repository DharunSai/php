<?php
session_start();
require_once 'DB.php';
require_once 'User.php';

// Redirect to user page if the user is already logged in
if (User::isLoggedIn()) {
    header("Location: index.php");
    exit();
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Perform signup
    if (User::isUsernameAvailable($username)) {
        if (User::signup($username, $password)) {
            $success = "Signup successful! Please login.";
        } else {
            $error = "Error while signing up. Please try again.";
        }
    } else {
        $error = "Username is already taken. Please choose a different username.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Car Parking Vault - Signup</title>
</head>
<body>
    <h1>Signup</h1>
    <form method="post">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required><br><br>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br><br>
        <input type="submit" value="Signup">
    </form>
    
    <?php if (isset($success)) : ?>
        <p><?php echo $success; ?></p>
    <?php endif; ?>
    <?php if (isset($error)) : ?>
        <p><?php echo $error; ?></p>
    <?php endif; ?>
</body>
</html>
