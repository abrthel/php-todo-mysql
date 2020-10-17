<?php
  require dirname(__FILE__).'/config.php';
  require dirname(__FILE__).'/includes/categories.php';

  $connection = new MySQLi(HOST, USER, PASSWORD, DATABASE);

  if( $connection->connect_errno ) {
      die('Connection failed: ' . $connection->connect_error);
  }

  $categories = new Categories($connection);

  $category_id = null;
  $category = null;
  $action = "New Category";

  if(isset($_GET['id'])) {
    $category_id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
    $category = $categories->by_id($category_id);
    $action = "Edit";
  }

  if(filter_input(INPUT_SERVER, 'REQUEST_METHOD') === 'POST') {
    if(isset($_POST['action']) && $_POST['action'] === 'remove') {
      $categories->remove($category_id);

    } else {
      $category = filter_input(INPUT_POST, 'category', FILTER_SANITIZE_STRING);
      $category_id = filter_input(INPUT_POST, 'category_id', FILTER_VALIDATE_INT);

      if(!$category_id){
        $categories->add($category);

      } else {
        $categories->edit($category_id, $category);

      }
    }
    header('Location: categories.php');
  }
  $connection->close();
?>

<?php require dirname(__FILE__).'/partials/header.php' ?>

<h1><?= $action ?> <?= $category ?></h1>

<form action="category.php" method="POST">
  <input type="hidden" name="category_id" value="<?= $category_id ?>" />

  <label for="category">Category:</label>
  <input type="text" id="category" name="category" value="<?= $category ?>" required/>

  <a href="/categories.php">Cancel</a>
  <button type="submit">Confirm</button>
</form>

<?php require dirname(__FILE__).'/partials/footer.php' ?>
