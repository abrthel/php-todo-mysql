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

  function add($category) {
    $query = "
      INSERT INTO categories (category)
      VALUES (?);
    ";

    $stmt = $this->conn->prepare($query);
    $stmt->bind_param("s", $category);
    if (!$stmt->execute()) {
      die("DB Query Failed (".$stmt->errno."): ".$stmt->error);
    }
  }

  function edit($id, $category) {
    $query = "
      UPDATE categories
      SET category = ?
      WHERE category_id = ?;
    ";

    $stmt = $this->conn->prepare($query);
    $stmt->bind_param("si", $category, $id);
    if (!$stmt->execute()) {
      die("DB Query Failed (".$stmt->errno."): ".$stmt->error);
    }
  }

  function by_id($id) {
    if(empty($this->allCategories)) {
      $this->allCategories = $this->getAll();
    }

    return $this->allCategories[$id]['category'];
  }

  function unused_categories() {
    $query = "
      SELECT categories.category_id
      FROM categories
      LEFT JOIN tasks t on categories.category_id = t.category_id
      WHERE task_id IS NULL
    ";

    $stmt = $this->conn->prepare($query);
    $stmt->execute();
    $result = $stmt->get_result();
    $empty_cats = [];
    while($value = $result->fetch_assoc()) {
      $empty_cats[] = $value['category_id'];
    }
    return $empty_cats;
  }

  function remove($id) {
    $query = "
      DELETE FROM categories
      WHERE category_id = ?;
    ";

    $stmt = $this->conn->prepare($query);
    $stmt->bind_param("i", $id);
    if (!$stmt->execute()) {
      die("DB Query Failed (".$stmt->errno."): ".$stmt->error);
    }
  }
}
