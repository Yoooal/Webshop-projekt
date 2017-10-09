<?php

$user_name = getPost("name");
$user_pass = getPost("pass");

$app->user->validate($user_name, $user_pass);
