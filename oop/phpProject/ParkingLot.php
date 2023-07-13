<?php
class ParkingLot {
    private $lotId;
    private $availability;
    private $carId;

    public function getLotId() {
        return $this->lotId;
    }

    public function setLotId($lotId) {
        $this->lotId = $lotId;
    }

    public function getAvailability() {
        return $this->availability;
    }

    public function setAvailability($availability) {
        $this->availability = $availability;
    }

    public function getCarId() {
        return $this->carId;
    }

    public function setCarId($carId) {
        $this->carId = $carId;
    }

    public static function getAvailableParkingLots() {
        $conn = DB::getConnection();
        $stmt = $conn->query("SELECT * FROM parking_lots WHERE availability = 0");
        $availableLots = array();
        while ($row = $stmt->fetch_assoc()) {
            $lot = new ParkingLot();
            $lot->setLotId($row['lotId']);
            $lot->setAvailability($row['availability']);
            $lot->setCarId($row['carId']);
            $availableLots[] = $lot;
        }
        return $availableLots;
    }

    public static function getLotById($lotId) {
        $conn = DB::getConnection();

        $stmt = $conn->prepare("SELECT * FROM parking_lots WHERE lotId = ?");

        

               
        $stmt->bind_param("i", $lotId);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $stmt->close();
        if ($row) {
            $lot = new ParkingLot();
            $lot->setLotId($row['lotId']);
            $lot->setAvailability($row['availability']);
            $lot->setCarId($row['carId']);
            return $lot;
        }
        return null;
    }

    public function update() {
        $conn = DB::getConnection();
        $stmt = $conn->prepare("UPDATE parking_lots SET availability = ?, carId = ? WHERE lotId = ?");
        $stmt->bind_param("ssi", $this->availability, $this->carId, $this->lotId);
        $stmt->execute();
        $stmt->close();
    }
}
?>
