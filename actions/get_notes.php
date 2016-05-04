<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once '../models/NoteCollection.php';
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

if (!isset($request['offset']) || !isset($request['count']))
    exit();

$offset = (int)Database::clearText($request['offset']);
$count = (int)Database::clearText($request['count']);

$noteCollection = new NoteCollection();
$noteCollection->userid = $user->id;

$deleted = 0;
if (isset($request['deleted']) && $request['deleted'] == "1")
    $deleted = 1;

if (isset($request['date'])) {
    $date = Database::clearText($request['date']);
    $noteCollection->getUserNotesInDate($offset, $count, $date, $deleted);
} else {
    $noteCollection->getUserNotes($offset, $count, $deleted);
}

$notes = $noteCollection->notes;
echo json_encode($notes);

?>