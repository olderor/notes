<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once '../models/note.php';
require_once '../models/user.php';
require_once '../models/mysql.php';

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
$noteid = (int)Database::clearText($request['noteid']);
if ($noteid < 0)
    $note->createNewNote($user->id);
else
    $note->getNote($noteid);

$note->title = isset($request['title']) ? Database::clearText($request['title']) : "";
$note->text = isset($request['text']) ? Database::clearText($request['text']) : "";
$note->importance = Database::clearText($request['importance']);
date_default_timezone_set("UTC");
$note->datetime = date("Y-m-d H:i:s");
$note->saveNote();

setCookie('time', $note->datetime, time() + 3600, '/');
setCookie('lastId', $note->id, time() + 3600, '/');
exit();

?>