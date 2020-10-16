<?php

class Todos {
  public $conn;

  function __construct($con)
  {
    $this->conn = $con;
  }

  function getAll() {
    $query = "
      SELECT task_id, category_id, date_due, date_completed, description
      FROM tasks
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

        if($record['date_due'] > date('Y-m-d')) {
          array_push($active, $record);
        } else {
          array_push($overdue, $record);
        }
      }
    }

    return [$active, $overdue, $completed];
  }

  function clear() {}

  function add($entry) {
    $query = "
      INSERT INTO tasks (category_id, date_due, description)
      VALUES (?, ?, ?);
    ";

    $stmt = $this->conn->prepare($query);
    $stmt->bind_param("sss", $entry['category_id'], $entry['date_due'], $entry['description']);
    if (!$stmt->execute()) {
      die("DB Query Failed (".$stmt->errno."): ".$stmt->error);
    }
  }

  function complete() {}

  function remove() {}
}
