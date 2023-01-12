<?php
class Database {
    private $db_hostname = "localhost";
    private $db_port = 3307;
    private $db_username = "root";
    private $db_password = "";
    private $db_database = "classes";
    

    public $pdo;

    public function dbConnexion() {
        
        try {
            $db = new PDO("mysql:host={$this->db_hostname}; dbname={$this->db_database}; port={$this->db_port}", $this->db_username,  $this->db_password);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            echo "connection to database successful";
            $this->pdo = $db;
        } catch (PDOException $e) {
            echo "failed to connect to database";
        }
    
    }
}

?>