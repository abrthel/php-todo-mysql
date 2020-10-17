<?php
  require dirname(__FILE__).'/config.php';
  require dirname(__FILE__).'/includes/todos.php';
  require dirname(__FILE__).'/includes/todo.form.php';
  require dirname(__FILE__).'/includes/todo_action.form.php';
  require dirname(__FILE__).'/includes/categories.php';

  $connection = new MySQLi(HOST, USER, PASSWORD, DATABASE);

  if( $connection->connect_errno ) {
      die('Connection failed: ' . $connection->connect_error);
  }

  $todos = new Todos($connection);
  $categories = new Categories($connection);
  $todoForm = new TodoForm('', '', '');

  if(filter_input(INPUT_SERVER, 'REQUEST_METHOD') === 'POST') {

    if (!empty($_POST['action'])) {
      $todoActionForm = new TodoActionForm($_POST['action'], $_POST['task_id']);

      if($todoActionForm->isValid()) {
        switch($todoActionForm->action) {
          case 'remove':
            $todos->remove($todoActionForm->task_id);
            break;
          case 'complete':
            $todos->complete($todoActionForm->task_id);
            break;
        }
      }
    }

    if (isset($_POST['task'])) {
      $todoForm = new TodoForm($_POST['task'], $_POST['category'], $_POST['date_due']);

      if($todoForm->isValid()) {
        $todos->add($todoForm->to_assoc());
        $todoForm = new TodoForm('', '', '');
      }
    }
  }


  [$active, $overdue, $completed] = $todos->getAll();
  $allCategories = $categories->getAll();

  $connection->close();
?>

<?php require dirname(__FILE__).'/partials/header.php' ?>

<h1>My PHP TODO</h1>
<a href="/categories.php">Edit Categories</a>

<h2>Add a To-Do</h2>

<?php if(!empty($todoForm->messages)) : ?>
<div class="errors">
  <p>Ohh no! There were some validation errors.</p>
  <ul>
    <?php $errors = $todoForm->messages; ?>
    <?php foreach($errors as $error) : ?>
      <li><?= $error ?></li>
    <? endforeach ?>
  </ul>
</div>
<?php endif ?>

<form action="index.php" method="POST">

    <label for="task">Enter a new task:</label>
    <input type="text" id="task" name="task" value="<?= $todoForm->description ?>"/>

    <label for="date_due">Due Date:</label>
    <input type="date" id="date_due" name="date_due" value="<?= $todoForm->date_due ?>" />

    <label for="category">Due Date:</label>
    <select type="" id="category" name="category">
      <?php foreach ($allCategories as $index => $value) : ?>
        <option <?= $value['category_id'] === $todoForm->category_id ? 'selected' : '' ?> value="<?= $value['category_id'] ?>"><?= $value['category'] ?></option>
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
<?php if (!empty($overdue)) : ?>
<table class="overdue">
  <?php foreach ($overdue as $task) : ?>
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

<h2>Completed</h2>
<?php if (!empty($completed)) : ?>
<table>
  <?php foreach ($completed as $task) : ?>
    <tr>
      <td><?= $categories->by_id($task['category_id']) ?></td>
      <td><?= $task['description'] ?></td>
      <td><?= $task['date_due'] ?></td>
      <td>
        <form action="index.php" method="POST" autocomplete="off">
          <input type="hidden" name="task_id" value="<?= $task['task_id'] ?>">
          <button type="submit" name="action" value="remove">X</button>
        </form>
      </td>
    </tr>
  <?php endforeach; ?>
</table>
<?php endif ?>

<?php require dirname(__FILE__).'/partials/footer.php' ?>
