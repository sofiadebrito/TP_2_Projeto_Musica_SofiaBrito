<?php
class Database {
    private $host = "localhost";
    private $db_name = "music_db";
    private $username = "root"; // <--- Falta esta linha!
    private $password = "";
    public $conn;

    public function getConnection() {
        $this->conn = null;
        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
        } catch(PDOException $e) {
            echo "Erro na ligação: " . $e->getMessage();
        }
        return $this->conn;
    }
}
?>