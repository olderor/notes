<?php

class Note
{
    public $id;
    public $userid;
    public $importance;
    public $text;
    public $datetime;

    public function newNote($userid) {
        $this->userid;
        $this->importance = 0;
        $this->text = "";
        $this->datetime = "";
    }
    
    public function saveNote() {
        Database::updateNote($this);
    }

    public function getNote($id) {

        $note = Database::getNote($id);

        if (count($note) == 0)
            Error::newError(11, "Failed to get note with id '$id''");

        $this->id = $note['id'];
        $this->userid = $note['user_id'];
        $this->importance = $note['importance'];
        $this->text = $note['text'];
        $this->datetime = $note['datetime'];
    }

}

?>