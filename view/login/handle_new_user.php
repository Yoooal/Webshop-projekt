<?php
$db = $app->db;
$db->connect();

// Handle incoming POST variables
$user_name = getPost("new_name");
$user_pass = getPost("new_pass");
$re_user_pass = getPost("re_pass");
$firstName = getPost("first_name");
$lastName = getPost("last_name");


if ($user_name != null) {
    if ($user_pass == $re_user_pass) {
        $crypt_pass = password_hash($user_pass, PASSWORD_DEFAULT);
        $sql = "INSERT INTO Customer (username, password, firstName, lastName) VALUES (?, ?, ?, ?);";
        $db->execute($sql, [$user_name, $crypt_pass, $firstName, $lastName]);
        $usersId = $db->lastInsertId();
        $sql = "CALL createVarukorg(?)";
        $db->execute($sql, [$usersId]);
        header('Location: ' . $_SERVER['HTTP_REFERER']);
    }
}
