<?php
class Database {
    private $db_hostname = "localhost";
    private $db_port = 3307;
    private $db_username = "root";
    private $db_password = "";
    private $db_database = "classes";
    

    public $mysqli;

    public function dbConnexion() {
        
        $conn = new mysqli($this->db_hostname, $this->db_username, $this->db_password, $this->db_database, $this->db_port);
        
        if($conn->connect_errno){
            echo "failed DB connection" . $conn->connect_error;
            exit();
        }
        echo "connection successful";
    
    $this->mysqli = $conn;
    }
}

?>