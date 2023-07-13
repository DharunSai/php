<?php
session_start();
require_once 'DB.php';
require_once 'User.php';

// Check if the user is already logged in, then redirect to the user page
if (User::isLoggedIn()) {
    header("Location: index.php");
    exit();
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if the form is for login or signup
    if (isset($_POST['login'])) {
        // Get form inputs for login
        $username = $_POST['username'];
        $password = $_POST['password'];

        $user = User::login($username, $password);

        // Perform login validation
        if ($user) {

            
            // Redirect to the user page

            
            header("Location: index.php");
            exit();
        } else {
            $error = "Invalid username or password. Please try again.";
        }
    } elseif (isset($_POST['signup'])) {
        // Get form inputs for signup
        $username = $_POST['username'];
        $password = $_POST['password'];

        // Perform signup
        if (User::signup($username, $password)) {
            $success = "Signup successful! Please log in.";
        } else {
            $error = "Error during signup. Please try again.";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Car Parking Vault - Login</title>
</head>
<body>
    <h1>Login</h1>
    <form method="post">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required><br><br>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br><br>
        <input type="submit" name="login" value="Login">
       
    </form>

    <a href="signup.php">Signup</a>
    <?php if (isset($error)) : ?>
        <p><?php echo $error; ?></p>
    <?php endif; ?>
    <?php if (isset($success)) : ?>
        <p><?php echo $success; ?></p>
    <?php endif; ?>
</body>
</html>
