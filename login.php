<?php

require 'mysql.php';

class User {
    
    public $id;
    public $mail;
    public $hashpass;
    
    public function newUser($mail, $password) {
        
        $user = Database::getUser($mail);
        if (self::checkIfUserExist($user))
            Error::newError(10, "Invalid input. User with mail '$mail' is already registered");
        
        $hashpass = password_hash($password, PASSWORD_DEFAULT);
        
        Database::newUser($mail, $hashpass);
        
        $this->id = Database::$last_id;
        $this->mail = $mail;
        $this->hashpass = $hashpass;
    }
    
    public function getUser($mail, $pass) {
        
        $user = Database::getUser($mail);
        if (self::checkIfUserExist($user))
            Error::newError(11, "Invalid input. User with mail '$mail' was not found");
        
        $this->id = $user['id'];
        $this->mail = $user['mail'];
        $this->hashpass = $user['hashpass'];
        
    }
    
    private static function checkIfUserExist($user) {
        return count($user) != 0;
    }
    
}

?>