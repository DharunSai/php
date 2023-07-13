<?php
require_once 'DB.php';
require_once 'ParkingLot.php';

class Utilization {
    private $utilizationId;
    private $userId;
    private $slotId;
    private $carNumber;
    private $intime;
    private $outtime;

    public function __construct($utilizationId, $userId, $slotId, $carNumber, $intime, $outtime) {
        $this->utilizationId = $utilizationId;
        $this->userId = $userId;
        $this->slotId = $slotId;
        $this->carNumber = $carNumber;
        $this->intime = $intime;
        $this->outtime = $outtime;
    }

    public function getUtilizationId() {
        return $this->utilizationId;
    }

    public function getUserId() {
        return $this->userId;
    }

    public function getSlotId() {
        return $this->slotId;
    }

    public function getCarNumber() {
        return $this->carNumber;
    }

    public function getIntime() {
        return $this->intime;
    }

    public function getOuttime() {
        return $this->outtime;
    }

    public function setOuttime($outtime) {
        $this->outtime = $outtime;
    }

    public function calculatePrice() {
        // Implement your price calculation logic here
        // You can use the intime and outtime to calculate the duration and then calculate the price based on the duration
        // Return the calculated price
    }

    public static function recordIntime($userId, $slotId, $carNumber, $intime) {
        // Check if the user already has an active utilization record
        if (self::isUserHasActiveUtilization($userId)) {
            return false; // User already has an active utilization record
        }

        // Check if the selected slot is available
        $availableSlots = ParkingLot::getAvailableParkingSlots();
        if (!in_array($slotId, $availableSlots)) {
            return false; // Selected slot is not available
        }
        ParkingLot::updateSlotAvailability($slotId,1);
        // Create a new utilization record
        $conn = DB::getConnection();
        $stmt = $conn->prepare("INSERT INTO utilization (userId, slotId, carNumber, intime) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("iiss", $userId, $slotId, $carNumber, $intime);
        $result = $stmt->execute();
        $utilizationId = $stmt->insert_id;
        $stmt->close();

        // Update the availability of the selected slot in the parking lot
        if ($result) {
            ParkingLot::updateSlotAvailability($slotId, 0);
        }

        return $utilizationId==1;
    }

    public static function hasUserParkedCar($userId) {
        $conn = DB::getConnection();
        $stmt = $conn->prepare("SELECT COUNT(*) AS count FROM utilization WHERE userId = ? AND outtime IS NULL");
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $stmt->close();
        return $row['count'] > 0;
    }

    // Check if the user already has an active utilization record
    private static function isUserHasActiveUtilization($userId) {
        $conn = DB::getConnection();
        $stmt = $conn->prepare("SELECT * FROM utilization WHERE userId = ? AND outtime IS NULL");
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        return $result->num_rows > 0;
    }

    public static function getUtilizationBySlot($slotId) {
        $conn = DB::getConnection();
        $stmt = $conn->prepare("SELECT * FROM utilization WHERE slotId = ?");
        $stmt->bind_param("s", $slotId);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows === 1) {
            $row = $result->fetch_assoc();
            $utilization = new Utilization($row['utilizationId'], $row['userId'], $row['slotId'], $row['carNumber'], $row['intime'], $row['outtime']);
            $stmt->close();
            return $utilization;
        }
        $stmt->close();
        return null;
    }

     public static function recordOuttime($userId, $slotId, $outtime) {
        $conn = DB::getConnection();
        $stmt = $conn->prepare("UPDATE utilization SET outtime = ? WHERE userId = ? AND slotId = ?");
        $stmt->bind_param("sii", $outtime, $userId, $slotId);
        $stmt->execute();
        $utilizationId = $stmt->insert_id;
        $stmt->close();

        ParkingLot::updateSlotAvailability($slotId,0);
        // $stmt = $conn->prepare("UPDATE parking_lots SET availability = 0 WHERE lotId = ? ");
        // $stmt->bind_param("i",  $slotId);
        // $stmt->execute();
        // $stmt->close();
        return $utilizationId;
    }

    public function update() {
        $conn = DB::getConnection();
        $stmt = $conn->prepare("UPDATE utilization SET outtime = ? WHERE utilizationId = ?");
        $stmt->bind_param("si", $this->outtime, $this->utilizationId);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }

    public static function isSlotAssignedToUser($userId, $slotId) {
        $conn = DB::getConnection();
        $stmt = $conn->prepare("SELECT * FROM utilization WHERE userId = ? AND slotId = ?");
        $stmt->bind_param("is", $userId, $slotId);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        return $result->num_rows === 1;
    }
}
?>
