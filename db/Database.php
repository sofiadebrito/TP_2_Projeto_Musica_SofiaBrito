<?php

// Classe para criar a ligacao com a base de dados
class Database {
    // Definir as variaveis de ligacao
    private $host = "localhost"; // Servidor local
    private $db_name = "music_db"; // Nome da base de dados
    private $username = "root"; // Nome do utilizador
    private $password = "admin"; // Palavra-passe
    public $conn; // Variavel para guardar a ligacao

    // Função para criar a ligação com a base de dados
    public function getConnection() {
        $this->conn = null;

        try {
            // Tentar criar a ligação usando PDO (forma segura de ligar ao MySQL em PHP)
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
        } catch(PDOException $e) {
            // Se houver um erro, mostrar a mensagem de erro
            echo "Erro na ligação: " . $e->getMessage();
        }
        // Retorna a ligacao para ser usada em outros ficheiros
        return $this->conn;
    }
}
?>