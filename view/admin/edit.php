<?php
$app->admin->checkIfAdmin();

$status = '<div class="alert alert-info" role="alert">Edit here</div>';

$params = getPost([
      "contentTitle",
      "contentPath",
      "contentSlug",
      "contentData",
      "contentType",
      "contentFilter",
      "contentPublish",
      "contentId"
  ]);

if (hasKeyPost("doSave")) {
    $app->admin->updateContent($params);
    $status = '<div class="alert alert-success" role="alert">Edit saved!</div>';
}

$contentId = getGet("id");
$sql = "SELECT * FROM content WHERE id = ?;";
$content = $app->db->executeFetch($sql, [$contentId]);
$cat = ["page", "post", "block"];
?>

<div class="container" role="main">
  <div class="page-header">
      <h1>Edit</h1>
  </div>
  <div class="page-content">
    <div class="row">
      <div class="col-md-6">
        <br>
        <?=$status?>
        <form action="" method="POST">
          <div class="form-group">
            <label>Title:</label>
            <input type="text" name="contentTitle" class="form-control" placeholder="Title here.." value="<?= esc($content->title) ?>"/>
          </div>
          <div class="form-group">
            <label>Path:</label>
            <input type="text" name="contentPath" class="form-control" placeholder="Path here.." value="<?= esc($content->path) ?>"/>
          </div>
          <div class="form-group">
            <label>Slug:</label>
            <input type="text" name="contentSlug" class="form-control" placeholder="Slug here.." value="<?= esc($content->slug) ?>"/>
          </div>
          <div class="form-group">
            <label>Text:</label>
            <textarea name="contentData" class="form-control" rows="5"><?= esc($content->data) ?></textarea>
          </div>
          <div class="form-group">
              <label>Type:</label>
              <select class="form-control" name="contentType">
                <?php foreach ($cat as $row) :
                    if ($row == $content->type): ?>
                    <option selected><?= $row ?></option>
                  <?php else: ?>
                    <option><?= $row ?></option>
                  <?php endif; ?>
                <?php endforeach; ?>
              </select>
          </div>
          <div class="form-group">
            <label>Filter:</label>
            <input type="text" name="contentFilter" class="form-control" placeholder="Filter here.." value="<?= esc($content->filter) ?>"/>
            <!-- <select multiple name="contentFilter" class="form-control">
              <option>nl2br</option>
              <option>bbcode</option>
              <option>link</option>
              <option>markdown</option>
            </select> -->
          </div>
          <div class="form-group">
            <label>Publish:</label>
            <input type="datetime" name="contentPublish" class="form-control" value="<?= esc($content->published) ?>"/>
          </div>
          <input type="hidden" name="contentId" value="<?= esc($content->id) ?>">
          <button type="submit" class="btn btn-lg btn-primary btn-block" name="doSave" >Save</button>
        </form>
      </div>
    </div>
  </div>
</div>
