<?php


// NOTE: I opted for a bit of duplication here (IE: repeating the form class) instead
//       of abstracting out a full form management solution. If I had more forms then it
//       would make sense but for two or three it isn't worth it.

class TodoActionForm {
  public $action;
  public $task_id;

  public $messages = [];
  private $known_actions = ['remove', 'complete'];

  function __construct($action, $task_id)
  {
    $this->action = filter_var($action, FILTER_SANITIZE_STRING);
    $this->task_id = filter_var($task_id, FILTER_VALIDATE_INT);
  }

  function messagesFor($field) {
    return $this->messages[$field] ?? [];
  }

  function isValid() {
    if(!$this->action) {
      $this->addMessage('action', "Must provide an action");
    } else {
      if(!in_array( $this->action, $this->known_actions)) {
        $this->addMessage('action', "Only acceptable actions are 'remove' or 'complete'.");
      }
    }

    if(empty($this->task_id)) {
      $this->addMessage('task_id', "A task_id must be given.");
    }

    return empty($this->messages);
  }

  private function addMessage($field, $message) {
    if(empty($this->messages[$field])) {
      $this->messages[$field] = [];
    }

    $this->messages[$field][] = $message;
  }
}
