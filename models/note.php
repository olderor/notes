<?php

require_once 'mysql.php';

class Note
{
    public $id;
    public $userid;
    public $title;
    public $importance;
    public $text;
    public $datetime;

    public function newNote($userid) {
        $this->id = 0;
        $this->userid;
        $this->title = "untitled";
        $this->importance = 0;
        $this->text = "";
        date_default_timezone_set("UTC");
        $this->datetime = date("Y-m-d H:i:s");
    }

    public function parseNote($note) {
        $this->id = $note['id'];
        $this->userid = $note['user_id'];
        $this->title = $note['title'];
        $this->importance = $note['importance'];
        $this->text = $note['text'];
        $this->datetime = $note['datetime'];
    }

    public function createNewNote($userid) {
        date_default_timezone_set("UTC");
        $date = date("Y-m-d H:i:s");
        $query = "INSERT INTO `" . Database::$notes_table . "`(`id`, `user_id`, `title`, `importance`, `text`, `datetime`, `deleted`) VALUES (NULL, $userid, \"\",0,\"\",'" . $date . "',0)";
        Database::sendQuery($query);
        $this->id = Database::$last_id;
        $this->userid = $userid;
        $this->title = "";
        $this->importance = 0;
        $this->text = "";
        $this->datetime = $date;
    }

    public function saveNote() {
        $query = "UPDATE `" . Database::$notes_table . "` SET `title`='$this->title', `importance`='$this->importance', `text`='$this->text', `datetime`='$this->datetime' WHERE `id`=$this->id";
        Database::sendQuery($query);
    }

    public function getNote($id) {

        $query = "SELECT * FROM `" . Database::$notes_table . "` WHERE `id`='$id'";
        $note = Database::sendQueryWithResult($query)[0];

        if (count($note) == 0)
            ErrorHandler::newError(11, "Failed to get note with id '$id''");

        $this->id = $note['id'];
        $this->userid = $note['user_id'];
        $this->title = $note['title'];
        $this->importance = $note['importance'];
        $this->text = $note['text'];
        $this->datetime = $note['datetime'];
    }

    public function checkIfNoteExist($id) {

        $query = "SELECT * FROM `" . Database::$notes_table . "` WHERE `id`='$id'";
        $note = Database::sendQueryWithResult($query)[0];

        return count($note) != 0;
    }


    public function deleteNote() {
        $query = "UPDATE `" . Database::$notes_table . "` SET `deleted`=1 WHERE `id`=$this->id";
        Database::sendQuery($query);
    }
}


?>