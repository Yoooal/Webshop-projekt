<?php
$app->admin->checkIfAdmin();

// Handle incoming POST variables
$id = getPost("id");
$title = getPost("contentTitle");

if (hasKeyPost("doCreate")) {
  $app->admin->createContent($title);
}

$sql = "SELECT * FROM content;";
$content = $app->db->executeFetchAll($sql);
?>

<div class="container" role="main">
  <div class="page-header">
      <button type="button" class="btn btn-default btn-lg pull-right" data-toggle="modal" data-target="#addContent">
        <i class="fa fa-file-text-o" aria-hidden="true"></i> Add Content
      </button>
      <h1>Content</h1>
  </div>
  <div class="page-content">
    <div class="row">
      <div class="col-md-12">
        <table class="table">
          <thead>
            <tr>
                <th>#</th>
                <th>Title</th>
                <th>Type</th>
                <th>Published</th>
                <th>Created</th>
                <th>Updated</th>
                <th>Deleted</th>
                <th>Actions</th>
            </tr>
          </thead>
        <?php $id = -1; foreach ($content as $row) :
        ?>
          <tbody>
            <tr>
                <td><?= $row->id ?></td>
                <td><?= $row->title ?></td>
                <td><?= $row->type ?></td>
                <td><?= $row->published ?></td>
                <td><?= $row->created ?></td>
                <td><?= $row->updated ?></td>
                <td><?= $row->deleted ?></td>
                <td><a type="button" class="btn btn-primary" href="edit?id=<?= $row->id ?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                    <a type="button" class="btn btn-danger" href="delete?id=<?= $row->id ?>"><i class="fa fa-trash-o" aria-hidden="true"></i></a></td>
            </tr>
          </tbody>
        <?php endforeach; ?>
        </table>
      </div>
    </div>
    <div class="modal fade" id="addContent" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Create Content</h4>
      </div>
      <div class="modal-body">
        <form role="form" method="POST" action="">
            <div class="form-group">
              <label for="contentTitle">Title: </label>
              <input type="text" name="contentTitle" class="form-control" />
            </div>
            <button type="submit" class="btn btn-primary" name="doCreate">Add</button>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
    </div>
    </div>
  </div>
</div>
