<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once '../models/note.php';

$request = null;
if ($_SERVER['REQUEST_METHOD'] == 'GET')
    $request = $_GET;
else if ($_SERVER['REQUEST_METHOD'] == 'POST')
    $request = $_POST;

if ($request == null)
    exit();

$user = unserialize($_SESSION['user']);

if (!isset($request['noteid']))
    exit();

$note = new Note();
$note->getNote((int)Database::clearText($request['noteid']));
date_default_timezone_set("UTC");
$note->datetime = date("Y-m-d H:i:s");
$note->saveNote();
$note->deleteNote();

exit();

?>