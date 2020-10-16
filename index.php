<?php
  require_once dirname(__FILE__).'/config.php';
  require_once dirname(__FILE__).'/includes/todos.php';
  require_once dirname(__FILE__).'/includes/categories.php';

  $connection = new MySQLi(HOST, USER, PASSWORD, DATABASE);

  if( $connection->connect_errno ) {
      die('Connection failed: ' . $connection->connect_error);
  }


  if(filter_input(INPUT_SERVER, 'REQUEST_METHOD') === 'POST') {

  }

  $todos = new Todos($connection);
  $categories = new Categories($connection);

  [$active, $overdue, $completed] = $todos->getAll();
  $allCategories = $categories->getAll();

  echo "<pre>";
  print_r($active);
  echo "</pre>";

  echo "<pre>";
  print_r($overdue);
  echo "</pre>";

  echo "<pre>";
  print_r($completed);
  echo "</pre>";



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

    <label for="due-date">Due Date:</label>
    <input type="date" id="due-date" name="due-date" />

    <label for="category">Due Date:</label>
    <select type="" id="category" name="catetory">
      <?php foreach ($allCategories as $index => $value) : ?>
        <option value="<?= $value['category_id'] ?>"><?= $value['category'] ?></option>
      <?php endforeach; ?>
    </select>

    <input type="submit" value="Add to List" />
  </form>

  <h2>Things To Do</h2>
  <ul>
    <?php foreach ($active as $index => $value) : ?>

      <li>
        <form action="index.php" method="POST">
          <input type="checkbox" id="active<?= $index ?>" name="active<?= $index ?>" onChange='submit();' />
          <label for="active<?= $index ?>"><?= $value['description'] ?></label>
        </form>
      </li>
    <?php endforeach; ?>
  </ul>


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
