<?php

class Error {
    
    public static $isAPI = false;
    
    public static function newError($code, $message) {
        if (self::$isAPI)
            self::sendError($code, $message);
        else
            self::showError($code, $message);
    }
    
    private static function sendError($code, $message) {
        $result = array("error" => array("error_code" => $code, "error_message" => $message));
        header("Content-type: application/json");
        echo json_encode($result);
        exit;
    }
    
    private static function showError($code, $message) {
        echo "<script>alert(\"Error \($code\): $message\");</script>";
        exit;
    }
    
}

?>