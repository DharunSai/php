<?php
class Car {
    private $carId;
    private $carNumber;

    public function getCarId() {
        return $this->carId;
    }

    public function setCarId($carId) {
        $this->carId = $carId;
    }

    public function getCarNumber() {
        return $this->carNumber;
    }

    public function setCarNumber($carNumber) {
        $this->carNumber = $carNumber;
    }

    public function save() {
        $conn = DB::getConnection();
        $stmt = $conn->prepare("INSERT INTO cars (carNumber) VALUES (?)");
        $stmt->bind_param("s", $this->carNumber);
        $stmt->execute();
        $this->carId = $stmt->insert_id;
        $stmt->close();
    }
}
?>
