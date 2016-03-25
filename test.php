<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require 'user.php';

$user = unserialize($_SESSION['user']);

echo $user->mail . ' ' . $user->id . '\n';

?>