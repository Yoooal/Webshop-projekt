<?php
$session = $app->session;

// Check if someone is logged in
if ($session->has("name")) {
    $session->destroy();
    $app->response->redirect($app->url->create(""));
} else {
  $app->response->redirect($app->url->create(""));
}
