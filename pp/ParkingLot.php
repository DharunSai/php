<?php
require_once 'DB.php';

class ParkingLot {
    public static function getAvailableParkingSlots() {
        $conn = DB::getConnection();
        $stmt = $conn->prepare("SELECT lotId FROM parking_lots WHERE availability = 0");
        $stmt->execute();
        $result = $stmt->get_result();
        $slots = [];
        while ($row = $result->fetch_assoc()) {
            $slots[] = $row['lotId'];
        }
        $stmt->close();
        return $slots;
    }

    public static function updateSlotAvailability($slotId, $availability) {
        $conn = DB::getConnection();
        $stmt = $conn->prepare("UPDATE parking_lots SET availability = ? WHERE lotId = ?");
        $stmt->bind_param("ii", $availability, $slotId);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }

    public static function isSlotAssignedToUser($userId,$slotId) {
        $conn = DB::getConnection();
        $stmt = $conn->prepare("SELECT COUNT(*) AS count FROM utilization WHERE userId = ? AND slotId = ? AND outtime IS NULL");
        $stmt->bind_param("ii", $userId, $slotId);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $stmt->close();
        return $row['count'] ;
    }

    public static function getAssignedSlotsByUser($userId) {
        $conn = DB::getConnection();
        $stmt = $conn->prepare("SELECT slotId FROM utilization WHERE userId = ? AND outtime IS NULL");
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        $slots = [];
        while ($row = $result->fetch_assoc()) {
            $slots[] = $row['slotId'];
        }
        $stmt->close();
        return $slots;
    }

    public static function getFilledSlots() {
        $conn = DB::getConnection();
        $stmt = $conn->prepare("SELECT lotId FROM parking_lots WHERE availability = 1");
        $stmt->execute();
        $result = $stmt->get_result();
        $slots = [];
        while ($row = $result->fetch_assoc()) {
            $slots[] = $row['lotId'];
        }
        $stmt->close();
        return $slots;
    }

    public static function getAvailableSlots() {
        $conn = DB::getConnection();
        $stmt = $conn->prepare("SELECT * FROM parking_lots WHERE availability = 0");
        $stmt->execute();
        $result = $stmt->get_result();
        $slots = [];
        while ($row = $result->fetch_assoc()) {
            $slots[] = $row['lotId'];
        }
        $stmt->close();
        return $slots;
    }

    



    public static function isSlotAvailable($slotId) {
        $conn = DB::getConnection();
        $stmt = $conn->prepare("SELECT availability FROM parking_lots WHERE lotId = ?");
        $stmt->bind_param("i", $slotId);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $stmt->close();
        return $row['availability']==0;
    }

    
}
?>
