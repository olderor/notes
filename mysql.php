<?php

require 'error_handler.php';

class Database {
    
    private static $db_name = 'notes';
    private static $users_table = 'users';
    private static $notes_table = 'notes';
    private static $link;
    
    public static $last_id;
    
    public static function connectToDb() {
        if (!(self::$link = mysqli_connect('localhost', 'root', "")))
            Error::newError(1, 'Connection failed: ' . mysqli_connect_error());

        if (mysqli_select_db(self::$link, self::$db_name) == 0)
            Error::newError(2, 'Failed to select database');
    }

    private static function sendQuery($query) {
        self::connectToDb();
        if (($result = mysqli_query(self::$link, $query)) == false)
            Error::newError(3, 'Request failed: ' . mysqli_error(self::$link));
        
        self::$last_id = mysqli_insert_id(self::$link);
        
        mysqli_close(self::$link);
        return;
    }
    
    private static function sendQueryWithResult($query) {
        self::connectToDb();
        if (($result = mysqli_query(self::$link, $query)) == false)
            Error::newError(3, 'Request failed: ' . mysqli_error(self::$link));
        
        $array = array();
        if ($row = mysqli_fetch_array($result)) {
            $array = $row;
        }
        
        mysqli_free_result($result);
        mysqli_close(self::$link);
        return $array;
    }
    
    public static function newUser($mail, $hashpass) {
        $query = "INSERT INTO `" . self::$users_table . "`(`id`, `mail`, `hashpass`) VALUES (NULL, '$mail', '$hashpass')";
        return self::sendQuery($query);
    }
    
    public static function getUser($mail) {        
        $query = "SELECT * FROM `" . self::$users_table . "` WHERE `mail`='$mail'";
        return self::sendQueryWithResult($query);
    }
}

?>