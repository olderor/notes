<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

header("Location: signin.php");

/*
$user = new User;
$user->newUser('815adsa@afss.com', '123123123');
*/


?>