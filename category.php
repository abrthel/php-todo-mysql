<?php
  require dirname(__FILE__).'/config.php';
  require dirname(__FILE__).'/includes/categories.php';

  $connection = new MySQLi(HOST, USER, PASSWORD, DATABASE);

  if( $connection->connect_errno ) {
      die('Connection failed: ' . $connection->connect_error);
  }

  $categories = new Categories($connection);

  // if(filter_input(INPUT_SERVER, 'REQUEST_METHOD') === 'POST') {

  //   if (!empty($_POST['action'])) {
  //     $todoActionForm = new TodoActionForm($_POST['action'], $_POST['task_id']);

  //     if($todoActionForm->isValid()) {
  //       switch($todoActionForm->action) {
  //         case 'remove':
  //           $todos->remove($todoActionForm->task_id);
  //           break;
  //         case 'complete':
  //           $todos->complete($todoActionForm->task_id);
  //           break;
  //       }
  //     }
  //   }

  //   if (isset($_POST['task'])) {
  //     $todoForm = new TodoForm($_POST['task'], $_POST['category'], $_POST['date_due']);

  //     if($todoForm->isValid()) {
  //       $todos->add($todoForm->to_assoc());
  //     }
  //   }
  // }

  $allCategories = $categories->getAll();

  // echo "<pre>";
  // print_r($active);
  // echo "</pre>";


  // echo "<pre>";
  // print_r(date('Y-m-d'));
  // echo "</pre>";

  // echo "<pre>";
  // print_r($overdue);
  // echo "</pre>";

  // echo "<pre>";
  // print_r($completed);
  // echo "</pre>";


  $connection->close();
?>

<?php require dirname(__FILE__).'/partials/header.php' ?>

<h1>Edit Categories</h1>


<h2></h2>
<form action="index.php" method="POST">
  <label for="category">Category:</label>
  <input type="text" id="category" name="category"/>

  <input type="submit" value="category" />
  <a href="/categories.php">Cancel</a>
</form>

<?php require dirname(__FILE__).'/partials/footer.php' ?>
