<?php
$db = $app->db;
$db->connect();

$sql = $app->sqlCode->getSqlCode("blog");
$resultset = $db->executeFetchAll($sql, ["post"]);

?>
<!-- Page Header -->
<header class="masthead" style="background-image: url('img/blog.jpg')">
  <div class="container">
    <div class="row">
      <div class="col-lg-12 col-md-12 mx-auto">
        <div class="site-heading">
          <h1>Blog</h1>
        </div>
      </div>
    </div>
  </div>
</header>

<div class="container" role="main">
  <div class="page-content">
    <div class="row">
      <div class="col-md-6">
        <article>
        <?php foreach ($resultset as $row) : ?>
        <section>
            <header>
                <h1><a href="blog/<?= esc($row->slug) ?>"><?= esc($row->title) ?></a></h1>
                <p><i>Published: <time datetime="<?= esc($row->published_iso8601) ?>" pubdate><?= esc($row->published) ?></time></i></p>
            </header>
            <p><?= substr(esc($row->data), 40, 200) ?> ...</p>
        </section>
        <br>
        <a class="btn btn-lg btn-primary" href="blog/<?= esc($row->slug) ?>">Read More</a>
        <hr>
        <br>
        <?php endforeach; ?>
        </article>
      </div>
    </div>
  </div>
</div>
