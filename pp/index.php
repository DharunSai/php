<?php
session_start();
require_once 'DB.php';
require_once 'User.php';
require_once 'ParkingLot.php';
require_once 'Utilization.php';

// Redirect to login page if the user is not logged in
if (!User::isLoggedIn()) {
    header("Location: login.php");
    exit();
}

// $availableSlots = ParkingLot::getAvailableSlots();

// Get the logged-in user
$user = unserialize(User::getLoggedInUser());

// Check if the user has already parked a car
$hasParkedCar = Utilization::hasUserParkedCar($user->getUserId());

// echo $hasParkedCar;
// var_dump($hasParkedCar);
// Handle the parking form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['park']) && $hasParkedCar!=true) {
    $carNumber = $_POST['carNumber'];

    if ($hasParkedCar) {
        $error = "You have already parked a car.";
    } else {
        $selectedSlot = $_POST['selectedSlot'];
        $intime = date('Y-m-d H:i:s');
        

        var_dump(ParkingLot::isSlotAvailable($selectedSlot));
        if (ParkingLot::isSlotAvailable($selectedSlot)) {
            $utilizationId = Utilization::recordIntime($user->getUserId(), $selectedSlot, $carNumber, $intime);

            if ($utilizationId) {
                ParkingLot::updateSlotAvailability($selectedSlot, 1);
                $success = "Car parked successfully!";

                // header('Location: index.php');

               
            } else {
                $error = "Error while parking the car. Please try again.";
            }
        } else {
            $error = "Selected parking slot is not available.";
        }
    }
}

elseif (isset($_POST['unpark']) &&  $hasParkedCar==true) {
    $selectedSlot = $_POST['selectedSlot'];

 
    var_dump(ParkingLot::isSlotAssignedToUser($user->getUserId(), $selectedSlot));


    
    if (ParkingLot::isSlotAssignedToUser($user->getUserId(), $selectedSlot)) {
        $outtime = date('Y-m-d H:i:s');
        $utilizationId = Utilization::recordOuttime($user->getUserId(), $selectedSlot, $outtime);
        // var_dump($utilizationId);
        if ($utilizationId) {
            $success = "Car unparked successfully!";

            // $u =Utilization::hasUserParkedCar($user->getUserId());

            // if($u==0)
            // {
            //     header("Location: index.php");
            // }
        } else {
            $error = "Error while unparking the car. Please try again.";
        }
    } else {
        $error = "Selected parking slot is not assigned to you.";
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Car Parking Vault - User Page</title>
</head>

<body>
    <h1>Welcome, <?php echo $user->getUsername(); ?></h1>
    <p>Car Parking Vault User Page</p>

    <?php if ($hasParkedCar) :$availableSlots = ParkingLot::getFilledSlots(); ?>
        <h2>Out Parking</h2>
        <form method="post">
            <label for="selectedSlot">Select Slot:</label>
            <select id="selectedSlot" name="selectedSlot" required>
                    <?php foreach ($availableSlots as $slot) { ?>
                        <option value="<?php echo $slot; ?>">
                            <?php echo $slot; ?>
                        </option>
                    <?php } ?>
                </select><br><br>
            <input type="submit" name="unpark" value="Unpark">
        </form>
    <?php else : ?>
        <h2>In Parking</h2>
        <?php
        $availableSlots = ParkingLot::getAvailableSlots();





        if (empty($availableSlots)) {
            echo "<p>No slots available at the moment. Please try again later.</p>";
        } else {
        ?>
            <form method="post">
                <label for="carNumber">Car Number:</label>
                <input type="text" id="carNumber" name="carNumber" required><br><br>
                <label for="selectedSlot">Select Slot:</label>

                <select id="selectedSlot" name="selectedSlot" required>
                    <?php foreach ($availableSlots as $slot) { ?>
                        <option value="<?php echo $slot; ?>">
                            <?php echo $slot; ?>
                        </option>
                    <?php } ?>
                </select><br><br>
                <input type="submit" name="park" value="Park">
            </form>
        <?php
        }
        ?>
    <?php endif; ?>

    <!-- <?php if (isset($success)) : ?>
        <p><?php echo $success; ?></p>
    <?php endif; ?>
    <?php if (isset($error)) : ?>
        <p><?php echo $error; ?></p>
    <?php endif; ?> -->

    <a href="logout.php">Logout</a>
</body>

</html>