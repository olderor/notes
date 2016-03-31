<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once '../models/user.php';
    
$request = null;
if ($_SERVER['REQUEST_METHOD'] == 'GET')
    $request = $_GET;
else if ($_SERVER['REQUEST_METHOD'] == 'POST')
    $request = $_POST;

$mail = $request["mail"];
$password = $request["password"];

$user = new User;
$user->newUser($mail, $password);

$_SESSION['user'] = serialize($user);

header("Location: signin.php");
exit();

?>