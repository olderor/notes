<?php

class Note
{
    public $id;
    public $userid;
    public $title;
    public $importance;
    public $text;
    public $datetime;

    public function newNote($userid) {
        $this->userid;
        $this->title = "untitled";
        $this->importance = 0;
        $this->text = "";
        $this->datetime = date("Y-m-d H:i:s");
    }

    public function parseNote($note) {
        $this->userid = $note['user_id'];
        $this->title = $note['title'];
        $this->importance = $note['importance'];
        $this->text = $note['text'];
        $this->datetime = $note['datetime'];
    }
    
    public function saveNote() {
        Database::updateNote($this);
    }

    public function getNote($id) {

        $note = Database::getNote($id);

        if (count($note) == 0)
            ErrorHandler::newError(11, "Failed to get note with id '$id''");

        $this->id = $note['id'];
        $this->userid = $note['user_id'];
        $this->title = $note['title'];
        $this->importance = $note['importance'];
        $this->text = $note['text'];
        $this->datetime = $note['datetime'];
    }

}

?>