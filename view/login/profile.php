<?php
$cookie = $app->cookie;

$app->user->checkIfLoggedIn();

$status = '<div class="alert alert-info" role="alert">Change Password</div>';
$user_name = $app->session->get("name");
$cookieStatus = '<div class="alert alert-danger" role="alert">No Cookie exist</div>';
$yourCookie = "";

if ($cookie->has($user_name)) {
  $yourCookie = $cookie->get($user_name);
  $cookieStatus = '<div class="alert alert-success" role="alert">Cookie exist</div>';
}

$sql = "SELECT * FROM Customer WHERE username LIKE ?;";
$user = $app->db->executeFetch($sql, [$user_name]);

// Handle incoming POST variables
$old_pass = getPost("old_pass");
$new_pass = getPost("new_pass");
$re_pass = getPost("re_pass");
$new_cookie = getPost("new_cookie");
$delete_cookie = getGet("delete_cookie");

if ($new_cookie != null) {
  $cookie->set($user_name, $new_cookie);
  header("Location: profile");
}

if ($delete_cookie != null) {
  $cookie->delete($user_name);
  header("Location: profile");
}

// Check if all fields are filled
if ($old_pass != null && $new_pass != null && $re_pass != null) {
    // Check if old password is correct
    if (password_verify($old_pass, $user->password)) {
        // Check if new password matches
        if ($new_pass == $re_pass) {
                $crypt_pass = password_hash($new_pass, PASSWORD_DEFAULT);
                $sql = "UPDATE Customer SET password = ? WHERE id = ?;";
                $app->db->execute($sql, [$crypt_pass, $user->id]);
                $status = '<div class="alert alert-success" role="alert">Password changed!</div>';
        } else {
            $status = '<div class="alert alert-danger" role="alert">The passwords do not match</div>';
        }
    } else {
        $status = '<div class="alert alert-danger" role="alert">Old password is incorrect</div>';
    }
}

?>

<div class="container" role="main">
    <div class="page-header">
        <h1>Profile: <?= $user_name ?></h1>
    </div>
    <div class="page-content">
      <div class="row">
        <div class="col-md-4">
          <h2>Change Password</h2>
          <?=$status?>
          <form action="" method="POST">
            <div class="form-group">
              <label>Old Password:</label>
              <input type="password" name="old_pass" class="form-control" placeholder="Old password" required>
            </div>
            <div class="form-group">
              <label>New Password:</label>
              <input type="password" name="new_pass" class="form-control" placeholder="New password" required>
            </div>
            <div class="form-group">
              <label>Re-enter Password:</label>
              <input type="password" name="re_pass" class="form-control" placeholder="Re-enter Password" required>
            </div>
            <button type="submit" class="btn btn-lg btn-primary btn-block" name="submitForm" value="Change password">Change Password</button>
          </form>
        </div>

      <div class="col-md-4 col-md-offset-1">
        <h2>Set a Cookie</h2>
        <?=$cookieStatus?>
        <h4>Your Cookie: <?=$yourCookie?></h4>
        <form action="" method="POST">
          <div class="form-group">
            <label>New Cookie:</label>
            <input type="text" name="new_cookie" class="form-control" placeholder="Cookie here..">
          </div>
          <button type="submit" class="btn btn-lg btn-primary btn-block" name="submitForm" value="setCookie">Set Cookie</button>
          <a href="?delete_cookie=hej" class="btn btn-lg btn-danger btn-block">Delete Cookie</a>
        </form>
      </div>
      <div class="col-md-2 col-md-offset-1">
        <h2>Orders</h2>
        <a type="button" class="btn btn-primary btn-lg" href="order">Show Orders</a>
      </div>
    </div>
  </div>
</div>
