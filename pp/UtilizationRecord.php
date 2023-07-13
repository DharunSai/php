<?php
class UtilizationRecord {
    private $vehicleNumber;
    private $duration;
    private $billAmount;
    private $timestamp;

    public function __construct($vehicleNumber, $duration, $billAmount, $timestamp) {
        $this->vehicleNumber = $vehicleNumber;
        $this->duration = $duration;
        $this->billAmount = $billAmount;
        $this->timestamp = $timestamp;
    }

    public function getVehicleNumber() {
        return $this->vehicleNumber;
    }

    public function getDuration() {
        return $this->duration;
    }

    public function getBillAmount() {
        return $this->billAmount;
    }

    public function getTimestamp() {
        return $this->timestamp;
    }

    public function save() {
        // Implement the logic to save the utilization record to the database
    }

    public static function getAllRecords() {
        // Implement the logic to fetch all utilization records from the database
        // and return an array of UtilizationRecord objects
    }
}
?>
