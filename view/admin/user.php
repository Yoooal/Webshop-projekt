<?php
$app->admin->checkIfAdmin();

$status = '<div class="alert alert-info" role="alert">Change Password</div>';

// Get number of hits per page
$hits = getGet("hits", 5);
if (!(is_numeric($hits) && $hits > 0 && $hits <= 9)) {
    die("Not valid for hits.");
}

// Get max number of pages
$sql = "SELECT COUNT(id) AS max FROM Customer;";
$max = $app->db->executeFetchAll($sql);
$max = ceil($max[0]->max / $hits);

// Get current page
$page = getGet("page", 1);
if (!(is_numeric($hits) && $page > 0 && $page <= $max)) {
    die("Not valid for page.");
}
$offset = $hits * ($page - 1);

// Only these values are valid
$columns = ["username"];
$orders = ["asc", "desc"];

// Get settings from GET or use defaults
$orderBy = getGet("orderby") ?: "username";
$order = getGet("order") ?: "asc";

// Incoming matches valid value sets
if (!(in_array($orderBy, $columns) && in_array($order, $orders))) {
    die("Not valid input for sorting.");
}

$sql = "SELECT * FROM Customer ORDER BY $orderBy $order LIMIT $hits OFFSET $offset;";
$resultset = $app->db->executeFetchAll($sql);
$defaultRoute = "user?";

// Handle incoming POST variables
$new_pass = getPost("new_pass");
$re_pass = getPost("re_pass");
$level = getPost("level");
$search = getPost("search");
$id = getPost("id");
$del = getGet("del");

if ($new_pass != null && $re_pass != null) {
    // Check if new password matches
    if ($new_pass == $re_pass) {
        $crypt_pass = password_hash($new_pass, PASSWORD_DEFAULT);
        $sql = "UPDATE Customer SET password = ? WHERE id = ?;";
        $app->db->execute($sql, [$crypt_pass, $id]);
        $status = '<div class="alert alert-success" role="alert">Password changed!</div>';
    } else {
        $status = '<div class="alert alert-danger" role="alert">The passwords do not match</div>';
    }
}

if ($id != null && $level != null) {
  $sql = "UPDATE Customer SET userLevel = ? WHERE id = ?;";
  $app->db->execute($sql, [$level, $id]);
  header("Location: user");
}

if ($del != null) {
  $sql = "DELETE FROM Customer WHERE id = ?;";
  $app->db->execute($sql, [$del]);
  header("Location: user");
}

if ($search != null) {
  $sql = "SELECT * FROM Customer WHERE username LIKE ?;";
  $resultset = $app->db->executeFetchAll($sql, [$search . "%"]);
}
?>

<div class="container" role="main">
  <div class="page-header">
      <button type="button" class="btn btn-default btn-lg pull-right" data-toggle="modal" data-target="#addUser">
        <i class="fa fa-user-plus" aria-hidden="true"></i> Add User
      </button>
      <h1>Users</h1>
  </div>
  <div class="page-content">
    <div class="row">
    <div class="col-md-12">
      <br>
      <div class="row">
        <div class="col-md-6">
          <form class="" action="user" method="post">
            <div id="custom-search-input">
                <div class="input-group col-md-12">
                    <input type="search" name="search" class="form-control input-lg" placeholder="Search username" />
                    <span class="input-group-btn">
                        <button class="btn btn-info btn-lg" type="button">
                            <i class="glyphicon glyphicon-search"></i>
                        </button>
                    </span>
                </div>
            </div>
          </form>
        </div>
        </div>
        <div class="row">
          <div class="col-md-12">
        <table class="table">
          <nav aria-label="Page navigation">
            <ul class="pagination">
              <li><a href="<?= mergeQueryString(["hits" => 3], $defaultRoute) ?>">2</a></li>
              <li><a href="<?= mergeQueryString(["hits" => 5], $defaultRoute) ?>">4</a></li>
              <li><a href="<?= mergeQueryString(["hits" => 9], $defaultRoute) ?>">8</a></li>
            </ul>
          </nav>
          <thead>
            <tr>
              <th>Username <?= orderby("username", $defaultRoute) ?></th>
              <th>First Name</th>
              <th>Last Name</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
            <?php
            foreach ($resultset as $row) {
              if ($row->username == "admin") {

              } else {
              ?>
                <tr>
                  <td><?= $row->username ?></td>
                  <td><?= $row->firstName ?></td>
                  <td><?= $row->lastName ?></td>
                  <td>
                  <form action="user" method="POST">
                    <input type="password" name="new_pass" placeholder="New password" required>
                    <input type="password" name="re_pass" placeholder="Re-enter Password" required>
                    <button type="submit" class="btn btn-sm btn-primary" name="submitForm" value="Change password">Change Password</button>
                    <input type="hidden" name="id" value="<?= $row->id ?>">
                  </form>
                  </td>
                  <td><a type="button" class="btn btn-danger" href='?del=<?= $row->id ?>'><i class="fa fa-trash-o" aria-hidden="true"></i></a></td>
                </tr>
              <?php
              }
            }
            ?>
          </tbody>
        </table>
        <b>Pages:</b>
        <nav aria-label="Page navigation">
          <ul class="pagination">
            <?php for ($i = 1; $i <= $max; $i++) : ?>
                <li><a href="<?= mergeQueryString(["page" => $i], $defaultRoute) ?>"><?= $i ?></a></li>
            <?php endfor; ?>
          </ul>
        </nav>
        </div>
        </div>
      </div>
    <div class="modal fade" id="addUser" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Create Account</h4>
      </div>
      <div class="modal-body">
        <form role="form" method="POST" action="handle_new_user">
            <div class="form-group">
                <label for="new_name">Username: </label>
                <input type="text" name="new_name" class="form-control" required autofocus />
            </div>
            <div class="form-group">
                <label for="new_pass">Password: </label>
                <input type="password" name="new_pass" class="form-control" required />
            </div>
            <div class="form-group">
                <label for="re_pass">Re-enter password: </label>
                <input type="password" name="re_pass" class="form-control" required />
            </div>
            <div class="form-group">
                <label for="new_name">First name: </label>
                <input type="text" name="first_name" class="form-control" required />
            </div>
            <div class="form-group">
                <label for="new_name">Last name: </label>
                <input type="text" name="last_name" class="form-control" required />
            </div>
            <button type="submit" class="btn btn-primary" name="submitCreateForm" value="Create">Add</button>
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
</div>
