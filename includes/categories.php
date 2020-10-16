<?php

class Categories {
  public $conn;
  private $allCategories = null;

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
    $result = $stmt->get_result();

    $set = array();

    while($value = $result->fetch_assoc()) {
      $set[$value['category_id']] = $value;
    }

    $this->allCategories = $set;
    return $set;
  }

  function add() {}

  function exit() {}

  function remove() {}

  function by_id($id) {
    if(empty($this->allCategories)) {
      $this->allCategories = $this->getAll();
    }

    return $this->allCategories[$id]['category'];
  }
}
