<?php
require_once 'DB.php';

class User {
    private $userId;
    private $username;

    public function __construct($userId, $username) {
        $this->userId = $userId;
        $this->username = $username;
    }

    public function getUserId() {
        return $this->userId;
    }

    public function getUsername() {
        return $this->username;
    }

    public static function isLoggedIn() {
        return isset($_SESSION['user']);
    }

    public static function getLoggedInUser() {
        if (self::isLoggedIn()) {
            return $_SESSION['user'];
        }
        return null;
    }

    public static function login($username, $password) {
        $conn = DB::getConnection();
        $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $row = $result->fetch_assoc();
            if (password_verify($password, $row['password'])) {
                $user = new User($row['userId'], $row['username']);
                $_SESSION['user'] = $user;
                return true;
            }
        }
        return false;
    }

    public static function signup($username, $password) {
        $conn = DB::getConnection();
        $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $stmt->bind_param("ss", $username, $hashedPassword);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }

    public static function isUsernameAvailable($username) {
        $conn = DB::getConnection();
        $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        return $result->num_rows === 0;
    }

    public static function logout() {
        session_unset();
        session_destroy();
    }
}
?>
