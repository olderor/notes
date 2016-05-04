<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once 'error_handler.php';
require_once 'note.php';

class Database {

    public static $db_name = 'u351977120_notes'; //'notes'
    public static $users_table = 'users';
    public static $notes_table = 'notes';
    private static $link;
    
    public static $last_id;
    
    public static function connectToDb() {
        //if (!(self::$link = mysqli_connect('localhost', 'root', "")))
        if (!(self::$link = mysqli_connect('localhost', 'u351977120_admin', "65366536")))
            ErrorHandler::newError(1, 'Connection failed: ' . mysqli_connect_error());

        if (mysqli_select_db(self::$link, self::$db_name) == 0)
            ErrorHandler::newError(2, 'Failed to select database');
    }

    public static function sendQuery($query) {
        self::connectToDb();
        if (($result = mysqli_query(self::$link, $query)) == false)
            ErrorHandler::newError(3, 'Request failed: ' . mysqli_error(self::$link));
        
        self::$last_id = mysqli_insert_id(self::$link);
        mysqli_close(self::$link);
    }

    public static function sendQueryWithResult($query) {
        self::connectToDb();
        if (($result = mysqli_query(self::$link, $query)) == false)
            ErrorHandler::newError(3, 'Request failed: ' . mysqli_error(self::$link));
        
        $array = array();
        while ($row = mysqli_fetch_array($result)) {
            array_push($array, $row);
        }
        
        mysqli_free_result($result);
        mysqli_close(self::$link);
        return $array;
    }

    public static function clearText($text) {
        self::connectToDb();
        $text = strip_tags($text);
        $text = htmlentities($text);
        $text = stripslashes($text);
        return mysqli_real_escape_string(self::$link, $text);
    }
}

?>