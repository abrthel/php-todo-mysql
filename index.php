<?php
  require_once dirname(__FILE__).'/config.php';
  require_once dirname(__FILE__).'/includes/todos.php';
  require_once dirname(__FILE__).'/includes/todo.form.php';
  require_once dirname(__FILE__).'/includes/todo_action.form.php';
  require_once dirname(__FILE__).'/includes/categories.php';

  $connection = new MySQLi(HOST, USER, PASSWORD, DATABASE);

  if( $connection->connect_errno ) {
      die('Connection failed: ' . $connection->connect_error);
  }

  $todos = new Todos($connection);
  $categories = new Categories($connection);
  $todoForm;

  if(filter_input(INPUT_SERVER, 'REQUEST_METHOD') === 'POST') {

    if (!empty($_POST['action'])) {
      $todoActionForm = new TodoActionForm($_POST['action'], $_POST['task_id']);

      if($todoActionForm->isValid()) {
        switch($todoActionForm->action) {
          case 'remove':
            $todos->remove($todoActionForm->task_id);
            break;
        }
      }
    }

    if (isset($_POST['task'])) {
      $todoForm = new TodoForm($_POST['task'], $_POST['category'], $_POST['date_due']);

      if($todoForm->isValid()) {
        $todos->add($todoForm->to_assoc());
      }
    }

    // echo "<pre>";
    // print_r($todoForm);
    // echo "</pre>";
  }


  [$active, $overdue, $completed] = $todos->getAll();
  $allCategories = $categories->getAll();

  // echo "<pre>";
  // print_r($active);
  // echo "</pre>";

  // echo "<pre>";
  // print_r($overdue);
  // echo "</pre>";

  // echo "<pre>";
  // print_r($completed);
  // echo "</pre>";



  $connection->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>TODO Application</title>
</head>
<body>

  <h1>My PHP TODO</h1>

  <form action="index.php" method="POST">
    <input type="submit" value="Clear" name="action" />
  </form>

  <h2>Add a To-Do</h2>
  <form action="index.php" method="POST">
    <label for="task">Enter a new task:</label>
    <input type="text" id="task" name="task" />

    <label for="date_due">Due Date:</label>
    <input type="date" id="date_due" name="date_due" />

    <label for="category">Due Date:</label>
    <select type="" id="category" name="category">
      <?php foreach ($allCategories as $index => $value) : ?>
        <option value="<?= $value['category_id'] ?>"><?= $value['category'] ?></option>
      <?php endforeach; ?>
    </select>

    <input type="submit" value="Add to List" />
  </form>


  <h2>Things To Do</h2>
  <?php if (!empty($active)) : ?>
  <table>
    <?php foreach ($active as $index => $task) : ?>
      <tr>
        <td><?= $categories->by_id($task['category_id']) ?></td>
        <td><?= $task['description'] ?></td>
        <td><?= $task['date_due'] ?></td>
        <td>
          <form action="index.php" method="POST" autocomplete="off">
            <input type="hidden" name="task_id" value="<?= $task['task_id'] ?>">
            <button type="submit" name="action" value="complete">Complete</button>
            <button type="submit" name="action" value="remove">X</button>
          </form>
        </td>
      </tr>
    <?php endforeach; ?>
  </table>
  <?php endif ?>


  <h2>Overdue</h2>
  <ul>
    <?php foreach ($overdue as $index => $value) : ?>
      <li><?= $value['description'] ?></li>
    <?php endforeach; ?>
  </ul>


  <h2>Completed</h2>
  <ul>
    <?php foreach ($completed as $index => $value) : ?>
      <li><?= $value['description']?></li>
    <?php endforeach; ?>
  </ul>
</body>
</html>
