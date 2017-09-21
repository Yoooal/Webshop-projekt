<?php
$session = $app->session;
$db = $app->db;
$db->connect();

$sql = $app->sqlCode->getSqlCode("showNews");
$resultset = $db->executeFetchAll($sql);
?>

<div class="carousel fade-carousel slide" data-ride="carousel" data-interval="4000" id="bs-carousel">
  <!-- Overlay -->
  <div class="overlay"></div>

  <!-- Indicators -->
  <ol class="carousel-indicators">
    <li data-target="#bs-carousel" data-slide-to="0" class="active"></li>
    <li data-target="#bs-carousel" data-slide-to="1"></li>
  </ol>

  <!-- Wrapper for slides -->
  <div class="carousel-inner">
    <div class="item slides active">
      <div class="slide-1"></div>
      <div class="hero">
        <hgroup>
          <img src="img/sneaker.png" alt="Avatar" class="img-responsive homeLogo">
          <h1>Sneaker Store</h1>
          <!-- <h3>Go and have a look at our awesome Products</h3> -->
        </hgroup>
        <a class="btn btn-hero btn-lg" href="<?= $app->url->create("products") ?>">Go to Products</a>
      </div>
    </div>
    <div class="item slides">
      <div class="slide-2"></div>
      <div class="hero">
        <hgroup>
          <img src="img/sneaker.png" alt="Avatar" class="img-responsive homeLogo">
          <h1>Sneaker Store</h1>
          <!-- <h3>Go and have a look at our awesome Blog</h3> -->
        </hgroup>
        <a class="btn btn-hero btn-lg" href="<?= $app->url->create("blog") ?>">Go to Blog</a>
      </div>
    </div>
  </div>
</div>


<div class="container">
   <div class="row newProducts">
     <h1 align="center">New Products</h1>
     <?php foreach ($resultset as $row) :?>
      <div class="item">
         <div class="col-xs-12 col-sm-6 col-md-3 team_columns_item_image">
            <a target="_blank" href="<?=$row->picture?>"><img src="<?= $row->picture ?>" alt="Responsive image"></a>
            <div class="team_columns_item_caption">
               <h4><?=$row->description?></h4>
               <hr>
               <h5><?=$row->category?></h5>
            </div>
         </div>
      </div>
      <?php endforeach; ?>
   </div>
</div>
