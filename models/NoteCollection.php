<?php

/**
 * Created by PhpStorm.
 * User: older
 * Date: 18.04.2016
 * Time: 13:17
 */
class NoteCollection
{
    public $userid;
    public $notes;

    public function getUserNotes() {
        $query = "SELECT * FROM `" . Database::$notes_table . "` WHERE (`user_id`=$this->userid AND `deleted`=0) ORDER BY `datetime` ASC";
        $response = Database::sendQueryWithResult($query);
        $this->notes = array();
        foreach ($response as $row) {
            $note = new Note();
            $note->parseNote($row);
            array_push($this->notes, $note);
        }
        $this->notes;
    }
    
    
}