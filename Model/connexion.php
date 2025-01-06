<?php
class Database {
    private $host = 'localhost';
    private $db_name = 'deltapital';
    private $username = 'root';
    private $password = '';
    public $conn;

    private static $instance = null;

    // Private constructor to prevent direct instantiation
    public function __construct() {
        $this->conn = null;
    }

    // Static method to get the instance
    public static function getInstance() {
        if (self::$instance == null) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    public function getConnection() {
        try {
            if ($this->conn === null) {
                $this->conn = new PDO("mysql:host={$this->host};dbname={$this->db_name}", $this->username, $this->password);
                $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            }
        } catch (PDOException $exception) {
            echo "Connection error: " . $exception->getMessage();
        }
        return $this->conn;
    }
}
?>
