<?php

class Categories {
  public $conn;

  function __construct($con)
  {
    $this->conn = $con;
  }

  function getAll() {
    $query = "
      SELECT category_id, category
      FROM categories
    ";

    $stmt = $this->conn->prepare($query);
    $stmt->execute();
    return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
  }

  function add() {}

  function exit() {}

  function remove() {}
}
