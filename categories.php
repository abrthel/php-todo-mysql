<?php
  require dirname(__FILE__).'/config.php';
  require dirname(__FILE__).'/includes/categories.php';

  $connection = new MySQLi(HOST, USER, PASSWORD, DATABASE);

  if( $connection->connect_errno ) {
      die('Connection failed: ' . $connection->connect_error);
  }

  $categories = new Categories($connection);

  $allCategories = $categories->getAll();

  $connection->close();
?>

<?php require dirname(__FILE__).'/partials/header.php' ?>

<h1>Edit Categories</h1>
<a href="/">Back to Todos</a>

<h2></h2>
<ul>
  <?php foreach($allCategories as $category) : ?>
    <li>
      <?= $category['category'] ?>
    </li>
  <?php endforeach ?>
</ul>
<a href="/category.php">Add new Category</a>

<?php require dirname(__FILE__).'/partials/footer.php' ?>
