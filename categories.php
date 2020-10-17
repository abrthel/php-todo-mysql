<?php
  require dirname(__FILE__).'/config.php';
  require dirname(__FILE__).'/includes/categories.php';

  $connection = new MySQLi(HOST, USER, PASSWORD, DATABASE);

  if( $connection->connect_errno ) {
      die('Connection failed: ' . $connection->connect_error);
  }

  $categories = new Categories($connection);

  $allCategories = $categories->getAll();
  $unused_categories = $categories->unused_categories();

  $connection->close();
?>

<?php require dirname(__FILE__).'/partials/header.php' ?>

<h1>Edit Categories</h1>
<a href="/">Back to Todos</a>

<h2></h2>
<table>
  <?php foreach($allCategories as $category) : ?>
    <tr>
      <td>
        <?= $category['category'] ?>
      </td>
      <td>
        <a href="/category.php?id=<?= $category['category_id'] ?>">Edit</a>

        <?php if(in_array($category['category_id'], $unused_categories)) : ?>
        <form action="category.php?id=<?= $category['category_id'] ?>">
          <button type="submit" name="action" value="remove">Remove</button>
        </form>
        <?php endif ?>
      </td>
    </tr>
  <?php endforeach ?>
</table>
<a href="/category.php">Add new Category</a>

<?php require dirname(__FILE__).'/partials/footer.php' ?>
