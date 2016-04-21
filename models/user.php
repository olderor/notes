<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once 'mysql.php';

class User {
    
    public $id;
    public $mail;
    public $hashpass;
    
    public function newUser($mail, $password) {

        $query = "SELECT * FROM `" . Database::$users_table . "` WHERE `mail`='$mail'";
        $user = Database::sendQueryWithResult($query)[0];
        if (self::checkIfUserExist($user))
            ErrorHandler::newError(10, "User with the mail '$mail' is already registered. Please, sign in", '../signin.php', array('mail' => $user['mail']));
        
        $hashpass = password_hash($password, PASSWORD_BCRYPT);

        $query = "INSERT INTO `" . Database::$users_table . "`(`id`, `mail`, `hashpass`) VALUES (NULL, '$mail', '$hashpass')";
        Database::sendQuery($query);
        
        $this->id = Database::$last_id;
        $this->mail = $mail;
        $this->hashpass = $hashpass;
    }
    
    public function getUser($mail, $password) {


        $query = "SELECT * FROM `" . Database::$users_table . "` WHERE `mail`='$mail'";
        $user = Database::sendQueryWithResult($query)[0];
        
        if (!self::checkIfUserExist($user))
            ErrorHandler::newError(11, "Invalid mail. User with the mail '$mail' was not found", '../signin.php');
        
        if (!password_verify($password, $user['hashpass']))
            ErrorHandler::newError(12, "Invalid password", '../signin.php', array('mail' => $user['mail']));
        
        $this->id = $user['id'];
        $this->mail = $user['mail'];
        $this->hashpass = $user['hashpass'];
        
    }
    
    private static function checkIfUserExist($user) {
        return count($user) != 0;
    }
    
}

?>