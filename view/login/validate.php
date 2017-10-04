<?php
$session = $app->session;
$db = $app->db;
$db->connect();

$content = '<div class="alert alert-danger" role="alert">User name or password is incorrect, Try again</div>';

// Handle incoming POST variables
$user_name = getPost("name");
$user_pass = getPost("pass");


if ($user_name != null && $user_pass != null) {
    // Check if username exists
    $sql = "SELECT * FROM Customer WHERE username LIKE ?;";
    $resultset = $db->executeFetch($sql, [$user_name]);
    $array = json_decode(json_encode($resultset), True);
    $password = $array["password"];

    // Verify user password
    if (password_verify($user_pass, $password)) {
        $session->set("name", $user_name);
        header("Location: profile");
    } else {
        // Redirect to login.php
        header('Location: ' . $_SERVER['HTTP_REFERER']);
    }
}
