<?php

class Todos {
  public $conn;

  function __construct($con)
  {
    $this->conn = $con;
  }

  function getAll() {
    $query = "
      SELECT entry_id, category_id, date_due, date_completed, description
      FROM entries
    ";

    $stmt = $this->conn->prepare($query);
    $stmt->execute();
    $result = $stmt->get_result();

    $active = [];
    $overdue = [];
    $completed = [];

    while($record = $result->fetch_assoc()) {
      if ($record['date_completed']) {
        array_push($completed, $record);
      } else {

        if($record['date_due'] < date('Y-m-d')) {
          array_push($active, $record);
        } else {
          array_push($overdue, $record);
        }
      }
    }

    return [$active, $overdue, $completed];
  }

  function clear() {}

  function add($entry) {}

  function complete() {}

  function remove() {}
}
