<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

class ErrorHandler {
    
    public static $isAPI = false;
    
    public static function newError($code, $message, $redirectURL = null, $params = null) {
        if (self::$isAPI)
            self::sendError($code, $message);
        else
            self::showError($code, $message, $redirectURL, $params);
    }
    
    private static function sendError($code, $message) {
        $result = array("error" => array("error_code" => $code, "error_message" => $message));
        header("Content-type: application/json");
        echo json_encode($result);
        exit;
    }
    
    private static function showError($code, $message, $redirectURL = null, $params) {
        echo "<script>alert(\"Error \($code\): $message\");</script>";
        if ($redirectURL != null)
            self::redirect($redirectURL, $message, $params);
        exit;
    }

    private static function redirect($url, $message, $params) {
        $location = "Location: $url?message=$message"; //TODO: go to root
        foreach ($params as $key => $value)
            $location = $location . "&$key=$value";
        error_log(print_r($location, TRUE));
        header($location);
        exit;
    }
    
}

?>