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
    // Get form inputs
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Perform signup
    if (User::isUsernameAvailable($username)) {
        if (User::signup($username, $password)) {
            // Redirect to the login page
            header("Location: login.php");
            exit();
        } else {
            $error = "Error during signup. Please try again.";
        }
    } else {
        $error = "Username is not available. Please choose a different username.";
    }
}

// Check if the request is an AJAX call to check username availability
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['username'])) {
    $username = $_GET['username'];
    $isUsernameAvailable = User::isUsernameAvailable($username);

    echo json_encode(['available' => $isUsernameAvailable]);
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Car Parking Vault - Sign Up</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#username').on('input', function() {
                var username = $(this).val();
                checkUsernameAvailability(username);
            });

            function checkUsernameAvailability(username) {
                $.ajax({
                    type: 'GET',
                    url: 'signup.php',
                    data: {username: username},
                    success: function(response) {
                        var result = JSON.parse(response);
                        if (result.available) {
                            $('#username-error').text('');
                        } else {
                            $('#username-error').text('Username is not available');
                        }
                    }
                });
            }
        });
    </script>
</head>
<body>
    <h1>Sign Up</h1>
    <form method="post">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required>
        <span id="username-error"></span><br><br>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br><br>
        <input type="submit" value="Sign Up">
    </form>
    <?php if (isset($error)) : ?>
        <p><?php echo $error; ?></p>
    <?php endif; ?>
</body>
</html>
