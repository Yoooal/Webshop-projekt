<?php

$totalPrice = 0;

$del = getGet("del");
$product = getGet("product");
$checkout = getGet("checkout");

if ($checkout != null) {
  $sql = "CALL fromVarukorgToOrder(?);";
  $app->db->execute($sql, [$checkout]);
  header("Location: order");
}

if ($del != null) {
  $sql = "CALL removeFromVarukorg(?, ?, ?);";
  $app->db->execute($sql, [$del, $product, 1]);
  header("Location: cart");
}

$content = $app->user->showCart();
?>

<div class="container" role="main">
  <div class="page-header">
    <?php if ($content != null) { ?>
      <a class="btn btn-primary btn-lg pull-right" href="cart?checkout=<?=$content[0]->varukorg?>"><i class="fa fa-credit-card"></i> Checkout</a>
    <?php } ?>
      <h1>Cart</h1>
  </div>
  <div class="page-content">
    <div class="row">
      <div class="col-md-12">
        <table class="table">
          <thead>
            <tr>
              <th>Bild</th>
              <th>Produkt</th>
              <th>Pris</th>
              <th>Kategori</th>
              <th>Lagerstatus</th>
              <th></th>
            </tr>
          </thead>
          <?php foreach ($content as $row) :
            $totalPrice += $row->price ?>
            <tbody>
              <tr>
                  <td><a target="_blank" href="<?=$row->picture?>"><img src="<?= $row->picture ?>" class="img-responsive img-rounded webshop" alt="Responsive image"></a></td>
                  <td><?= $row->description ?></td>
                  <td><?= $row->price ?> kr</td>
                  <td><?= $row->category ?></td>
                  <td><?= $row->items ?> st</td>
                  <td><a type="button" class="btn btn-danger" href="cart?del=<?= $row->id ?>&product=<?= $row->product ?>"><i class="fa fa-trash-o" aria-hidden="true"></i></a></td>
              </tr>
            </tbody>
          <?php endforeach; ?>
        </table>
        <hr>
        <h3>Total Price: <?= $totalPrice ?> kr</h3>
        <a type="button" class="btn btn-success btn-lg pull-right" href="<?= $app->url->create("products") ?>"><i class="fa fa-shopping-basket" aria-hidden="true"></i> Continue Shopping</a>
      </div>
    </div>
  </div>
</div>
