<?php
include_once("./../../App/Config.php");

include_once(MAIN_PATH . "/Views/layouts/header.php");
include_once(MAIN_PATH . '/App/Session.php');

include_once(MAIN_PATH . '/App/Database.php');
?>
<div class="container m-auto mt-5">
  <div class="card">
    <a href="<?php echo URL . 'Views/products/index.php' ?>" class="btn btn-success">Back</a>
    <h1 class="text-center bg-body-secondary">Update Product</h1>

    <?php

    if (Session::has('errors')) : ?>
      <div class="alert alert-danger">
        <?php foreach (Session::get("errors") as $error) : ?>
          <p><?= $error ?></p>
        <?php endforeach;


        ?>
      </div>

    <?php

    endif;
    Session::remove("errors");
    $database = new Database();
    $product = isset($_GET['id']) ? $database->getRow("products", ["id" => $_GET['id']]) : []
    ?>

    <?php
    if (Session::has('success')) : ?>
      <div class="alert alert-success">
        <p><?= Session::get("success") ?></p>
      </div>
    <?php

    endif;
    Session::remove("success");
    ?>
    <form action="<?php echo URL . 'Controllers/Products/Update.php' ?>" method="post" class=" p-3">
      <input type="text" hidden name="id" value="<?= $product['id'] ?>">
      <div class="mb-3">
        <label for="exampleFormControlInput1" class="form-label">NAME</label>
        <input type="text" class="form-control" id="exampleFormControlInput1" name="name" value="<?= $product['name'] ?? '' ?>">
      </div>

      <div class="mb-3">
        <label for="exampleFormControlInput1" class="form-label">Price</label>
        <input type="number" class="form-control" id="exampleFormControlInput1" name="price" value="<?= $product['price'] ?? '' ?>">
      </div>

      <div class="mb-3">
        <label for="exampleFormControlInput1" class="form-label">URL</label>
        <input type="text" class="form-control" id="exampleFormControlInput1" name="url" value="<?= $product['url'] ?? '' ?>">
      </div>
      <div class="mb-3 text-end">

        <button type="submit" class="btn btn-primary px-5">Update</button>
      </div>
    </form>




  </div>
</div>



<?php


include_once(MAIN_PATH . "/Views/layouts/footer.php");
?>