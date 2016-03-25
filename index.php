<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

header("Location: signin.html");

/*
$user = new User;
$user->newUser('815adsa@afss.com', '123123123');
*/


?>