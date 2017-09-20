<?php
$session = $app->session;
$db = $app->db;
$db->connect();

$ordersArray = [];
$a = 0;

$costumerName = $session->get("name");
$sql = "SELECT id FROM Customer WHERE username = ?;";
$customer = $db->executeFetch($sql, [$costumerName]);
$sql = $app->sqlCode->getSqlCode("showOrder");
$content = $db->executeFetchAll($sql, [$customer->id]);
?>

<div class="container" role="main">
  <div class="page-header">
    <h1>Orders</h1>
  </div>
  <div class="page-content">
    <?php foreach ($content as $row) :
      if (!in_array($row->order, $ordersArray)) {
        $totalPrice = 0;
        array_push($ordersArray, $row->order); ?>
        <div class="row">
          <div class="col-md-12">
            <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
              <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="heading<?=$row->order?>">
                  <h4 class="panel-title">
                    <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse<?=$row->order?>" aria-expanded="false" aria-controls="collapse<?=$row->order?>">
                      <i class="fa fa-sort" aria-hidden="true"></i> Order <?= $row->order ?>
                    </a>
                  </h4>
                </div>
                <div id="collapse<?=$row->order?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading<?=$row->order?>">
                  <div class="panel-body">
                    <table class="table">
                      <thead>
                        <tr>
                          <th>Bild</th>
                          <th>Produkt</th>
                          <th>Pris</th>
                          <th>Kategori</th>
                          <th>Antal</th>
                        </tr>
                      </thead>
                      <?php
                      foreach ($content as $row) :
                        if ($row->order == $ordersArray[$a]) {
                          $totalPrice += $row->price ?>
                          <tbody>
                            <tr>
                                <td><a target="_blank" href="<?=$row->picture?>"><img src="<?= $row->picture ?>" class="img-responsive img-rounded webshop" alt="Responsive image"></a></td>
                                <td><?= $row->description ?></td>
                                <td><?= $row->price ?> kr</td>
                                <td><?= $row->category ?></td>
                                <td><?= $row->items ?> st</td>
                            </tr>
                          </tbody>
                        <?php
                        } else {

                        }
                        endforeach;
                        $a++;
                      ?>
                    </table>
                    <hr>
                    <h3>Total Price: <?= $totalPrice ?> kr</h3>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      <?php } else {

      }
    endforeach;?>
  </div>
</div>
