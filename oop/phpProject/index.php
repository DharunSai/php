



<?php
session_start();
require_once 'DB.php';
require_once 'Car.php';
require_once 'User.php';
require_once 'ParkingLot.php';
require_once 'Utilization.php';
require_once 'Utility.php';

// Check if the user is logged in
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

// Retrieve the logged-in user object
$user = $_SESSION['user'];

$userInLogged = unserialize($user)->userId;





echo $userInLogged;


// $userChanged = unserialize($_SESSION['user']);

// $_SESSION['isParked']=User::getIsParkedById(2);
// echo unserialize($user)->userId;


// echo $_SESSION['isParked'];  

// echo $user;

// Retrieve the available parking lots
$availableLots = ParkingLot::getAvailableParkingLots();

// Handle the form submission for parking a car
if ($_SERVER['REQUEST_METHOD'] === 'POST' ) {
    
    $selectedLotId = $_POST['lotId'];
    $carNumber = $_POST['carNumber'];
   
   



    // Perform validations
    // ...

    // Create a new car object

    
    $car = new Car();
    $car->setCarNumber($carNumber);
    $car->save(); // Save the car details to the database

    // echo $car;

    // Calculate the bill amount
    

    // Create a new utilization object
    $utilization = new Utilization();
    $utilization->setCarId($car->getCarId());
    $utilization->setInTime(date('Y-m-d H:i:s'));
    $utilization->setIsCarIn(1);
    // $utilization->setBillAmount($billAmount);
    $utilization->setTimestamp(date('Y-m-d H:i:s'));
    $utilization -> setUserIsParked(unserialize($user)->getUserId());
    $utilization->saveB(); // Save the utilization details to the database

    // Update the parking lot availability and carId
    $selectedLot = ParkingLot::getLotById($selectedLotId);
    $selectedLot->setAvailability(1);
    $selectedLot->setCarId($car->getCarId());
    $selectedLot->update(); // Update the parking lot details in the database
    // $userChanged->isParked=1;

    // $_SESSION['isParked']=1;

    var_dump($userChanged);

    

    // $_SESSION['user']=serialize($userChanged);

    // var_dump($_SESSION['user']);
    // Redirect to the user page or display a success message
    // header("Location: indexParked1.php");


    
       
    
   
    exit();
}


?>

<!DOCTYPE html>
<html>
<head>
    <title>Car Parking Vault - User Page</title>
</head>
<body>
    
    <h2>Select a parking lot</h2>
    <form method="post" action="index.php">
        <select name="lotId">
            <?php foreach ($availableLots as $lot) : ?>
                <option value="<?php echo $lot->getLotId(); ?>"><?php echo $lot->getLotId(); ?></option>
            <?php endforeach; ?>
        </select>
        <br><br>
        <label for="carNumber">Car Number:</label>
        <input type="text" id="carNumber" name="carNumber" required><br><br>
        
       
        <input type="submit" value="In">
    </form>

             
    <!-- Display error messages or success message -->
    <a href="logout.php">Logout</a>
</body>
</html>

