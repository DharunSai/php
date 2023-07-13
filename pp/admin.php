<?php
session_start();
require_once 'DB.php';
require_once 'User.php';
require_once 'Utilization.php';

// Check if the admin is already logged in, then redirect to the admin page
if (!User::isAdminLoggedIn()) {
    header("Location: admin-login.php");
    exit();
}

// Retrieve the logged-in admin user object
$admin = $_SESSION['admin'];

// Retrieve the utilization details
$utilizations = Utilization::getAllUtilizations();

?>

<!DOCTYPE html>
<html>
<head>
    <title>Car Parking Vault - Admin Page</title>
</head>
<body>
    <h1>Welcome, Admin</h1>
    <h2>Utilization Details</h2>
    <table>
        <tr>
            <th>Vehicle Number</th>
            <th>Duration</th>
            <th>Bill Amount</th>
            <th>Timestamp</th>
        </tr>
        <?php foreach ($utilizations as $utilization) : ?>
            <tr>
                <td><?php echo $utilization->getCarNumber(); ?></td>
                <td><?php echo $utilization->getDuration(); ?> hours</td>
                <td><?php echo $utilization->getBillAmount(); ?></td>
                <td><?php echo $utilization->getTimestamp(); ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
    <a href="admin-logout.php">Logout</a>
</body>
</html>
