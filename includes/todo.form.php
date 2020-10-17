<?php

class TodoForm {
  public $description;
  public $category_id;
  public $date_due;

  public $messages = [];


  function __construct($description, $category_id, $date_due)
  {
    // Citation
    // https://stackoverflow.com/questions/23039207/sanitizing-a-date
    // Used to sanitize a date from user input.
    $this->date_due = preg_replace("([^0-9/] | [^0-9-])", "", $date_due);
    $this->description = filter_var($description, FILTER_SANITIZE_STRING);
    $this->category_id = filter_var($category_id, FILTER_VALIDATE_INT);
  }

  function to_assoc() {
    return array(
      'description' => $this->description,
      'category_id' => $this->category_id,
      'date_due' => $this->date_due,
    );
  }

  function isValid() {
    if(!$this->description) {
      $this->addMessage("Must provide a task.");
    }

    if(!$this->date_due) {
      $this->addMessage("Must provide a due date.");
    }

    if(!$this->category_id) {
      $this->addMessage("Must select a valid category.");
    }

    return empty($this->messages);
  }

  private function addMessage($message) {
    $this->messages[] = $message;
  }
}
