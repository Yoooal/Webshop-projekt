<?php
$session = $app->session;
$db = $app->db;
$db->connect();

if ($session->get("name") != "admin") {
  $app->response->redirect($app->url->create(""));
}

$sql = $app->sqlCode->getSqlCode("showWebshop");
$content = $db->executeFetchAll($sql);

if (hasKeyPost("doCreate")) {
  $params = getPost([
        "description",
        "picture",
        "price",
        "category",
        "items"
    ]);
    $sql = "INSERT INTO Product (description, picture, price) VALUES (?, ?, ?);";
    $db->execute($sql, [$params["description"], $params["picture"], $params["price"]]);
    $id = $db->lastInsertId();
    $sql = "INSERT INTO Prod2Cat (prod_id, cat_id) VALUES (?, ?);";
    $db->execute($sql, [$id, $params["category"]]);
    $sql = "INSERT INTO Inventory (prod_id, shelf_id, items) VALUES (?, ?, ?);";
    $db->execute($sql, [$id, "AAA102", $params["items"]]);
    header('Location: ' . $_SERVER['REDIRECT_URL']);
}
?>


<div class="container" role="main">
  <div class="page-header">
      <button type="button" class="btn btn-default btn-lg pull-right" data-toggle="modal" data-target="#addWebshop">
        <i class="fa fa-plus" aria-hidden="true"></i> Add Product
      </button>
      <h1>Webshop</h1>
  </div>
    <div class="page-content">
      <div class="row">
        <div class="col-md-12">
        <table class="table">
          <thead>
            <tr>
                <th>#</th>
                <th>Bild</th>
                <th>Produkt</th>
                <th>Pris</th>
                <th>Kategori</th>
                <th>Lagerstatus</th>
                <th>Lagerplats</th>
            </tr>
          </thead>
        <?php $id = -1; foreach ($content as $row) :?>
          <tbody>
            <tr>
                <td><?= $row->id ?></td>
                <td><img src="<?= $row->picture ?>" class="img-responsive img-rounded webshop" alt="Responsive image"></td>
                <td><?= $row->description ?></td>
                <td><?= $row->price ?></td>
                <td><?= $row->category ?></td>
                <td><?= $row->items ?></td>
                <td><?= $row->shelf ?></td>
                <td><a type="button" class="btn btn-primary" href="editWebshop?id=<?= $row->id ?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                    <a type="button" class="btn btn-danger" href="delete?id=<?= $row->id ?>"><i class="fa fa-trash-o" aria-hidden="true"></i></a></td>
            </tr>
          </tbody>
        <?php endforeach; ?>
        </table>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="addWebshop" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
<div class="modal-dialog" role="document">
<div class="modal-content">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title" id="myModalLabel">Add product</h4>
  </div>
  <div class="modal-body">
    <form action="" method="POST">
      <div class="form-group">
        <label>Produkt:</label>
        <input type="text" name="description" class="form-control"/>
      </div>
      <div class="form-group">
        <label>Bild:</label>
        <input type="text" name="picture" class="form-control"/>
      </div>
      <div class="form-group">
        <label>Pris:</label>
        <input type="text" name="price" class="form-control"/>
      </div>
      <div class="form-group">
          <label>Kategori:</label>
          <select class="form-control" name="category">
            <option value="1">Nike</option>
            <option value="2">Adidas</option>
            <option value="2">NewBalance</option>
          </select>
      </div>
      <div class="form-group">
        <label>Lager:</label>
        <input type="text" name="items" class="form-control"/>
      </div>
      <button type="submit" class="btn btn-lg btn-primary btn-block" name="doCreate" >Save</button>
    </form>
  </div>
  <div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
  </div>
</div>
</div>
</div>
