<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once 'models/user.php';

$user = unserialize($_SESSION['user']);

echo $user->mail . ' ' . $user->id . '\n';

?>