<?php
class DB {
    private static $servername = "localhost";
    private static $username = "root";
    private static $password = "admin@123";
    private static $dbname = "carVault";

    public static function getConnection() {
        $conn = new mysqli(self::$servername, self::$username, self::$password, self::$dbname);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        else
        {
           
        return $conn;
        
        }
    }
}
?>
