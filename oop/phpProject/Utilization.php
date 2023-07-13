<?php
class Utilization {
    private $utilizationId;
    private $carId;
    private $carNumber;
    private $inTime;
    private $outTime;
    private $billAmount;
    private $timestamp;
    private $isCarIn;

    public function getUtilizationId() {
        return $this->utilizationId;
    }

    public function setUtilizationId($utilizationId) {
        $this->utilizationId = $utilizationId;
    }

    

    public function getCarId() {
        return $this->carId;
    }

    public function setCarId($carId) {
        $this->carId = $carId;
    }

    public function getInTime() {
        return $this->inTime;
    }

    public function setInTime($inTime) {
        $this->inTime = $inTime;
    }

    public function getOutTime() {
        return $this->outTime;
    }

    public function setIsCarIn($isCarIn) {
        $this->isCarIn = $isCarIn;
    }

    public function getisCarIn() {
        return $this->isCarIn;
    }


    public function setOutTime($outTime) {
        $this->outTime = $outTime;
    }

    public function getBillAmount() {
        return $this->billAmount;
    }

    public function setBillAmount($billAmount) {
        $this->billAmount = $billAmount;
    }

    public function getTimestamp() {
        return $this->timestamp;
    }

    public function setTimestamp($timestamp) {
        $this->timestamp = $timestamp;
    }

    public static function getAllUtilizations() {


        $conn = DB::getConnection();
        $stmt = $conn->query("SELECT u.*, c.carNumber FROM utilization u INNER JOIN cars c ON u.carId = c.carId");
        $utilizations = array();
        while ($row = $stmt->fetch_assoc()) {
            $utilization = new Utilization();
            $utilization->setUtilizationId($row['utilizationId']);
            $utilization->setCarId($row['carId']);
            $utilization -> setIsCarIn($row['isCarIn']);
          
            $utilization->setInTime($row['timestamp']);
            $utilization->setBillAmount($row['billAmount']);
            $utilization->setTimestamp($row['timestamp']);
            $utilizations[] = $utilization;
        }
        return $utilizations;
    }

    public function save() {
        $conn = DB::getConnection();
        $stmt = $conn->prepare("INSERT INTO utilization (carId, inTime, billAmount, timestamp) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("iids", $this->carId, $this->inTime, $this->billAmount, $this->timestamp);
        $stmt->execute();
        $this->utilizationId = $stmt->insert_id;
        $stmt->close();


    }
    public function saveB() {
        $conn = DB::getConnection();
        $stmt = $conn->prepare("INSERT INTO utilization (carId, inTime) VALUES (?, ?)");
        $stmt->bind_param("is", $this->carId, $this->inTime);
        $stmt->execute();
        $this->utilizationId = $stmt->insert_id;
        $stmt->close();
    }

    public function setUserIsParked($userId)
    {
        $conn = DB::getConnection();
        $stmt = $conn->prepare("UPDATE users SET isParked = 1 WHERE userId={$userId};");
        // $stmt->bind_param("iids", $this->carId, $this->duration, $this->billAmount, $this->timestamp);
        $stmt->execute();
        // $this->utilizationId = $stmt->insert_id;
        $stmt->close();
    }

    public  function  calculateBillAmount()
    {
        $intime=strtotime($this->getInTime());
        $outtime = strtotime($this->getOutTime());

        if($outtime>$intime)
        {
            return $outtime;
        }




    }
}
?>
