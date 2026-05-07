<?php

class Ticket {

    public $id;
    public $title;
    public $status;
    public $assigned_to;
    public $date;

    public function __construct($id, $title, $status, $assigned_to, $date) {

        $this->id = $id;
        $this->title = $title;
        $this->status = $status;
        $this->assigned_to = $assigned_to;
        $this->date = $date;
    }

    public function toArray() {

        return [
            "id" => $this->id,
            "title" => $this->title,
            "status" => $this->status,
            "assigned_to" => $this->assigned_to,
            "date" => $this->date
        ];
    }
}

?>