<?php
$app->admin->checkIfAdmin();

$params = getPost([
      "description",
      "picture",
      "price",
      "category",
      "items"
  ]);

if (hasKeyPost("doCreate")) {
    $app->admin->createWebshop($params);
}

$sql = $app->sqlCode->getSqlCode("showWebshop");
$content = $app->db->executeFetchAll($sql);
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
        <label>Description:</label>
        <input type="text" name="description" class="form-control"/>
      </div>
      <div class="form-group">
        <label>Picture:</label>
        <input type="text" name="picture" class="form-control"/>
      </div>
      <div class="form-group">
        <label>Price:</label>
        <input type="text" name="price" class="form-control"/>
      </div>
      <div class="form-group">
          <label>Category:</label>
          <select class="form-control" name="category">
            <option value="1">Nike</option>
            <option value="2">Adidas</option>
            <option value="2">NewBalance</option>
          </select>
      </div>
      <div class="form-group">
        <label>Items:</label>
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
