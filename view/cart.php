<?php
$session = $app->session;
$db = $app->db;
$db->connect();

$del = isset($_GET["del"]) ? htmlentities($_GET["del"]) : null;
$product = isset($_GET["product"]) ? htmlentities($_GET["product"]) : null;
$checkout = isset($_GET["checkout"]) ? htmlentities($_GET["checkout"]) : null;

if ($checkout != null) {
  $sql = "CALL fromVarukorgToOrder(?);";
  $db->execute($sql, [$checkout]);
  header("Location: order");
}

if ($del != null) {
  $sql = "CALL removeFromVarukorg(?, ?, ?);";
  $db->execute($sql, [$del, $product, 1]);
  header("Location: cart");
}

$costumerName = $session->get("name");
$sql = "SELECT id FROM Customer WHERE username = ?;";
$customer = $db->executeFetch($sql, [$costumerName]);
$sql = "SELECT * FROM Varukorg WHERE customer = ?;";
$cart = $db->executeFetch($sql, [$customer->id]);
$sql = $app->sqlCode->getSqlCode("showCart");
$content = $db->executeFetchAll($sql, [$cart->id]);
$totalPrice = 0;
?>

<div class="container" role="main">
  <div class="page-header">
      <h1>Cart</h1>
  </div>
  <div class="page-content">
    <div class="row">
      <div class="col-md-12">
        <br>
        <a type="button" class="btn btn-primary btn-lg pull-right" href="cart?checkout=<?=$cart->id?>"><i class="fa fa-credit-card" aria-hidden="true"></i> Checkout</a>
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
                  <td><a type="button" class="btn btn-lg btn-danger" href="cart?del=<?= $row->id ?>&product=<?= $row->product ?>"><i class="fa fa-trash-o" aria-hidden="true"></i></a></td>
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
