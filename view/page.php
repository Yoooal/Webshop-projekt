<?php

$sql = $app->sqlCode->getSqlCode("page");
$route = $_SERVER["PATH_INFO"];
$page = substr($route, 7);
$content = $app->db->executeFetch($sql, [$page, "page"]);
if ($content == false) {
  $app->response->redirect($app->url->create("pages"));
}
$text = $content->data;

if (strlen($content->filter) > 2) {
  $text = $app->textfilter->doFilter($content->data, $content->filter);
}

?>

<div class="container" role="main">
  <div class="page-header">
      <h1><?= esc($content->title) ?></h1>
  </div>
  <div class="page-content">
    <div class="row">
      <div class="col-md-12 bak">
        <article>
            <header>
                <p><i>Latest update: <time datetime="<?= esc($content->modified_iso8601) ?>" pubdate><?= esc($content->modified) ?></time></i></p>
            </header>
            <?= $text ?>
        </article>
      </div>
    </div>
  </div>
</div>
