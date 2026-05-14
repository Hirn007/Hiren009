<?php
class Ticket {
    private $id;
    private $title;
    private $status;
    private $assignedTo;
    private $date;

    public function __construct($title, $status = 'Open', $assignedTo = 'Unassigned', $id = null, $date = null) {
        $this->id = $id ? $id : uniqid();
        $this->title = $title;
        $this->status = $status;
        $this->assignedTo = $assignedTo;
        $this->date = $date ? $date : date('Y-m-d H:i:s');
    }

    public function toArray() {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'status' => $this->status,
            'assignedTo' => $this->assignedTo,
            'date' => $this->date
        ];
    }

    public static function getAllTickets($filePath) {
        if (!file_exists($filePath)) {
            return [];
        }
        $json = file_get_contents($filePath);
        return json_decode($json, true) ?: [];
    }

    public function save($filePath) {
        $tickets = self::getAllTickets($filePath);
        $tickets[] = $this->toArray();
        file_put_contents($filePath, json_encode($tickets, JSON_PRETTY_PRINT));
    }
}
?>
