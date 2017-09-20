<?php
$db = $app->db;
$db->connect();

// Handle incoming POST variables
$user_name = isset($_POST["new_name"]) ? htmlentities($_POST["new_name"]) : null;
$user_pass = isset($_POST["new_pass"]) ? htmlentities($_POST["new_pass"]) : null;
$re_user_pass = isset($_POST["re_pass"]) ? htmlentities($_POST["re_pass"]) : null;
$firstName = isset($_POST["first_name"]) ? htmlentities($_POST["first_name"]) : null;
$lastName = isset($_POST["last_name"]) ? htmlentities($_POST["last_name"]) : null;


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
