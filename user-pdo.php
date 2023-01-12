<?php

    include('database/pdo.php');

    class Userpdo extends Database {
        public $id;
        public $login;
        public $email;
        public $firstname;
        public $lastname;

        public function __construct() {
            $this->dbConnexion();
        }


        public function userExist($login) {
            
            $query = "SELECT * FROM `utilisateurs` WHERE login = :login";

            $stmt = $this->pdo->prepare($query); 
            $stmt->bindParam(':login', $login); 
            $stmt->execute();
            
            if($stmt->rowCount() == 0) { 
                return false; 
            } else { 
                return true; 
            } 

        }

    public function register($login, $password, $email, $firstname, $lastname) {
      
        if($this->userExist($login) == false) {
            $query = "INSERT INTO `utilisateurs` (`login`, `password`, `email`, `firstname`, `lastname`) 
            VALUES (:login, :password, :email, :firstname, :lastname)";

            $stmt = $this->pdo->prepare($query);

            $stmt->bindParam(':login', $login);
            $stmt->bindParam(':password', $password);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':firstname', $firstname);
            $stmt->bindParam(':lastname', $lastname);
            
            $stmt->execute();
            
            // mysqli_query($this->mysqli, "");
        
        }
        else{
            echo "User is already exists";
        }
        
        



    }


    public function connect($login, $password){
        $query = "SELECT * FROM `utilisateurs` WHERE login = :login AND password = :password";
        
        $stmt = $this->pdo->prepare($query);

        $stmt = $stmt->bindParam(':login', $login);
        $stmt = $stmt->bindParam(':password', $password);

        $stmt->execute();
        
        // var_dump($result);
        if($stmt->rowCount() == 0) {
            echo "Login or password is incorrect";
        } else {
            //echo $login . " is connected";
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            $this->id = $user['id'];  // To put an id from Database to class id proporties
            $this->login = $user['login'];
            $this->email = $user['email'];
            $this->firstname = $user['firstname'];
            $this->lastname = $user['lastname'];

            $_SESSION['login'] = $login; 
            // var_dump($user);
        }

    }

    public function isConnected() {
        if(isset($_SESSION['login']) && $_SESSION['login'] == $this->login) {
            return true;
        }else {
            return false;
        }
    }

    public function disconnect(){

     if($this->isConnected()){
            unset($_SESSION);
            echo "$this->login is disconnected";
     }
  
    }

    public function delete(){
        $id = $this->id;

        $query = "DELETE FROM `utilisateurs` WHERE id = :id";


        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':id', $id);

        $stmt->execute();


        $return = ($stmt->rowCount() > 0) ? true : false;

        // var_dump($result);
   
    }

    /**
     * Method used to update the user's information in the database
     * 
     * @param string $login
     * @param string $email
     * @param string $password
     * @param string $firstname
     * @param string $lastname
     * 
     * @return bool - Returns TRUE if the user's info has been updated
     */
    public function update($login, $email, $password, $firstname, $lastname) {
        $id = $this->id;

        $query = "UPDATE `utilisateurs` SET login = :login, email = :email, password = :password, firstname = :firstname, lastname = :lastname WHERE id = :id";
        
        $stmt = $this->pdo->prepare($query);

        $stmt->bindParam(':login', $login);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password);
        $stmt->bindParam(':firstname', $firstname);
        $stmt->bindParam(':lastname', $lastname);
        $stmt->bindParam(':id', $id);

        $stmt->execute();
        
        $result = $stmt->rowCount() > 0;

        if($result) {
            $this->login = $login;
            $this->email = $email;
            $this->firstname = $firstname;
            $this->lastname = $lastname;
        }

        return $result;
        // var_dump($result);
   
    }


}


?>