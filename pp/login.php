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

    $user=User::login($username, $password);
    // Perform login validation
    if ($user) {
        // Redirect to the user page

        $_SESSION['u']=base64_encode(serialize($user));


       
        header("Location: index.php");
       
    } else {
        $error = "Invalid username or password. Please try again.";
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
        <input type="submit" value="Login">
    </form>
    <br>

    <a href="signup.php">signup</a>
    <?php if (isset($error)) : ?>
        <p><?php echo $error; ?></p>
    <?php endif; ?>
</body>
</html>
