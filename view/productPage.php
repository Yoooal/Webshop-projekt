<?php

$user_not_loggedin = "disabled";

if ($app->session->has("name")) {
  $user_not_loggedin = "";
}

$show = getGet("show");
$shop = getGet("shop");

if ($shop != null) {
  $app->user->shopProduct($shop);
}

$sql = "SELECT * FROM showWebshop WHERE id = ?;";
$content = $app->db->executeFetch($sql, [$show]);
?>

<div class="container" role="main">
  <div class="page-header">
      <h1>Product</h1>
  </div>
  <div class="page-content">
    <div class="row">
      <div class="col-md-6">
        <a target="_blank" href="<?= $content->picture ?>"><img src="<?= $content->picture ?>" class="img-responsive" alt="Responsive image"></a>
      </div>
      <div class="col-md-6">
        <h1><?= $content->description ?></h1>
        <h2><?= $content->category ?></h2>
        <hr>
        <h3>Items left: <?= $content->items ?></h3>
        <h3><?= $content->price ?> kr</h3>
        <hr>
        <a type="button" class="btn btn-lg btn-primary <?=$user_not_loggedin?>" href="product?shop=<?= $content->id ?>"><i class="fa fa-cart-plus" aria-hidden="true"></i></a>
      </div>
    </div>
  </div>
</div>
