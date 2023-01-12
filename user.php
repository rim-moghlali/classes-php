<?php

    include('database/mysqli.php');

    class User extends Database { 
        public  $id;
        public $login;
        public $email;
        public $firstname;
        public $lastname;

        public function __construct() {
            $this->dbConnexion();
        }

        public function userExist($login){

            $result = mysqli_query($this->mysqli, "SELECT * FROM `utilisateurs` WHERE login='$login'");
            if($result->num_rows == 0) {
                return false;
            } 
            else {
                return true;
            }
        }

    public function register($login, $email, $password, $firstname, $lastname){
      
        if($this->userExist($login) == false){
        mysqli_query($this->mysqli, "INSERT INTO `utilisateurs` (`login`, `password`, `email`, `firstname`, `lastname`) 
        VALUES ('$login', '$password', '$email', '$firstname', '$lastname')");
        
        }
        else{
            echo "User is already exists";
        }
        
        



    }


    public function connect($login, $password){
       $result = mysqli_query($this->mysqli, "SELECT * FROM `utilisateurs` WHERE login = '$login' AND password = '$password'");
        // var_dump($result);
    if($result->num_rows == 0){
            echo "Login or password is incorrect";

    }else{
            //echo $login . " is connected";
            $user = $result->fetch_assoc();

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
        $result = mysqli_query($this->mysqli, "DELETE FROM `utilisateurs` WHERE id = '$this->id'");
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
    public function update($login, $email, $password, $firstname, $lastname){
        $result = mysqli_query($this->mysqli, "UPDATE `utilisateurs` SET login = '$login', email = '$email', password = '$password', firstname = '$firstname', lastname = '$lastname' WHERE id = '$this->id'");
        
        if($result){
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