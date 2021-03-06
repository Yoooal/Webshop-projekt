<?php
$sql = $app->sqlCode->getSqlCode("blogpost");
$route = $_SERVER["PATH_INFO"];
$slug = substr($route, 6);
$content = $app->db->executeFetch($sql, [$slug, "post"]);
$text = $content->data;

if (strlen($content->filter) > 2) {
  $text = $app->textfilter->doFilter($content->data, $content->filter);
}
?>

<div class="container" role="main">
  <div class="page-header" align="center">
      <h1><?= esc($content->title) ?></h1>
  </div>
  <div class="page-content">
    <div class="row">
      <div class="col-md-8 col-md-offset-2">
        <article>
            <header>
                <p><i>Latest update: <time datetime="<?= esc($content->published_iso8601) ?>" pubdate><?= esc($content->published) ?></time></i></p>
            </header>
            <?= $text ?>
        </article>
      </div>
    </div>
  </div>
</div>
