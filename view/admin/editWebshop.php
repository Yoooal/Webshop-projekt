<?php
$app->admin->checkIfAdmin();

$status = '<div class="alert alert-info" role="alert">Edit here</div>';

//$params gets all values from getPost()
$params = getPost([
      "description",
      "picture",
      "price",
      "category",
      "items",
      "id"
  ]);

if (hasKeyPost("doSave")) {
    $app->admin->updateWebshop($params);
    $status = '<div class="alert alert-success" role="alert">Edit saved!</div>';
}

$contentId = getGet("id");
$sql = $app->sqlCode->getSqlCode("editWebshop");
$content = $app->db->executeFetch($sql, [$contentId]);
// get categories
$sql = "SELECT * FROM ProdCategory";
$cat = $app->db->executeFetchAll($sql);
?>

<div class="container" role="main">
    <div class="page-header">
        <h1>Edit</h1>
    </div>
    <div class="col-md-6 bak">
    <br>
    <?=$status?>
    <form action="" method="POST">
      <div class="form-group">
        <label>Produkt:</label>
        <input type="text" name="description" class="form-control" value="<?= esc($content->description) ?>"/>
      </div>
      <div class="form-group">
        <label>Bild:</label>
        <input type="text" name="picture" class="form-control" value="<?= esc($content->picture) ?>"/>
      </div>
      <div class="form-group">
        <label>Pris:</label>
        <input type="text" name="price" class="form-control" value="<?= esc($content->price) ?>"/>
      </div>
      <div class="form-group">
          <label>Level:</label>
          <select class="form-control" name="category">
            <?php $id = 0; foreach ($cat as $row) :
                $id++;
                if ($row->category == $content->category): ?>
                <option selected><?= $id . ") " . $row->category ?></option>
              <?php else: ?>
                <option><?= $id . ") " . $row->category ?></option>
              <?php endif; ?>
            <?php endforeach; ?>
          </select>
      </div>
      <div class="form-group">
        <label>Lager:</label>
        <input type="text" name="items" class="form-control" value="<?= esc($content->items) ?>"/>
      </div>
      <input type="hidden" name="id" value="<?= esc($content->id) ?>">
      <button type="submit" class="btn btn-lg btn-primary btn-block" name="doSave" >Save</button>
    </form>
  </div>
</div>
