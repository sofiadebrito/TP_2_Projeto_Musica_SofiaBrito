<?php

// ligacao à bd
class Database {
    
    private $host = "localhost"; 
    private $db_name = "music_db"; 
    private $username = "root"; 
    private $password = "admin"; 
    public $conn; // Variavel para guardar a ligacao

    
    public function getConnection() {
        $this->conn = null;

        try {
            // tentar criar a ligacao com PDO que é a forma segura de ligar ao MySQL
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
        } catch(PDOException $e) {

            // Se houver um erro, mostrar a mensagem de erro
            echo "Erro na ligação: " . $e->getMessage();
        }
      
        return $this->conn;
    }
}
?>