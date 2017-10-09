<?php

$user_name = getPost("new_name");
$user_pass = getPost("new_pass");
$re_user_pass = getPost("re_pass");
$firstName = getPost("first_name");
$lastName = getPost("last_name");

$app->user->handleNewUser($user_name, $user_pass, $re_user_pass, $firstName, $lastName);
