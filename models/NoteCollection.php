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

    public function getAllUserNotes($deleted = 0) {
        $query = "SELECT * FROM `" . Database::$notes_table . "` WHERE (`user_id`=" . Database::clearText($this->userid) .
            " AND `deleted`=" . $deleted . ") ORDER BY `datetime` DESC";
        $response = Database::sendQueryWithResult($query);
        $this->notes = array();
        foreach ($response as $row) {
            $note = new Note();
            $note->parseNote($row);
            array_push($this->notes, $note);
        }
    }

    public function getUserNotes($offset, $count, $deleted = 0) {
        $query = "SELECT * FROM `" . Database::$notes_table .
            "` WHERE (`user_id`=" . Database::clearText($this->userid) . " AND `deleted`=" . $deleted . ") ORDER BY `datetime` DESC LIMIT " .
            $offset . "," . $count;
        $response = Database::sendQueryWithResult($query);
        $this->notes = array();
        foreach ($response as $row) {
            $note = new Note();
            $note->parseNote($row);
            array_push($this->notes, $note);
        }
    }

    public function addUserNotes($offset, $count, $deleted = 0) {
        $query = "SELECT * FROM `" . Database::$notes_table .
            "` WHERE (`user_id`=" . Database::clearText($this->userid) . " AND `deleted`=" . $deleted . ") ORDER BY `datetime` DESC LIMIT " .
            $offset . "," . $count;
        $response = Database::sendQueryWithResult($query);
        
        if (!isset($this->notes))
            $this->notes = array();

        foreach ($response as $row) {
            $note = new Note();
            $note->parseNote($row);
            array_push($this->notes, $note);
        }
    }

    public function getUserNotesInDate($offset, $count, $date, $deleted = 0) {
        $query = "SELECT * FROM `" . Database::$notes_table .
            "` WHERE (`user_id`=" . Database::clearText($this->userid) . " AND `deleted`=" . $deleted . " AND `datetime` LIKE '" .
            $date . "%') ORDER BY `datetime` DESC LIMIT " .
            $offset . "," . $count;
        $response = Database::sendQueryWithResult($query);
        $this->notes = array();
        foreach ($response as $row) {
            $note = new Note();
            $note->parseNote($row);
            array_push($this->notes, $note);
        }
    }

    public function count() {
        return count($this->notes);
    }
}