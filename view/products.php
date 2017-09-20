<?php
$session = $app->session;
$db = $app->db;
$db->connect();

// Get number of hits per page
$hits = getGet("hits", 5);
if (!(is_numeric($hits) && $hits > 0 && $hits <= 9)) {
    die("Not valid for hits.");
}

// Get max number of pages
$sql = "SELECT COUNT(id) AS max FROM Product;";
$max = $db->executeFetchAll($sql);
$max = ceil($max[0]->max / $hits);

// Get current page
$page = getGet("page", 1);
if (!(is_numeric($hits) && $page > 0 && $page <= $max)) {
    die("Not valid for page.");
}
$offset = $hits * ($page - 1);

// Only these values are valid
$columns = ["description", "price", "category"];
$orders = ["asc", "desc"];

// Get settings from GET or use defaults
$orderBy = getGet("orderby") ?: "description";
$order = getGet("order") ?: "asc";

// Incoming matches valid value sets
if (!(in_array($orderBy, $columns) && in_array($order, $orders))) {
    die("Not valid input for sorting.");
}
$sql = <<<EOD
SELECT
  S.shelf,
  I.items,
  P.description,
  P.price,
  P.id,
  P.picture,
  GROUP_CONCAT(category) AS category
FROM Inventory AS I
  INNER JOIN InvenShelf AS S
    ON I.shelf_id = S.shelf
  INNER JOIN Product AS P
    ON P.id = I.prod_id
  INNER JOIN Prod2Cat AS P2C
    ON P.id = P2C.prod_id
  INNER JOIN ProdCategory AS PC
    ON PC.id = P2C.cat_id
GROUP BY P.id
ORDER BY $orderBy $order LIMIT $hits OFFSET $offset;
EOD;
$resultset = $db->executeFetchAll($sql);
$defaultRoute = "products?";

$search = isset($_POST["search"]) ? htmlentities($_POST["search"]) : null;
$id = isset($_POST["id"]) ? htmlentities($_POST["id"]) : null;
$shop = isset($_GET["shop"]) ? htmlentities($_GET["shop"]) : null;

if ($shop != null) {
  $costumerName = $session->get("name");
  $sql = "SELECT id FROM Customer WHERE username = ?;";
  $customer = $db->executeFetch($sql, [$costumerName]);
  $sql = "SELECT * FROM Varukorg WHERE customer = ?;";
  $cart = $db->executeFetch($sql, [$customer->id]);
  $sql = "CALL addToVarukorg(?, ?, ?);";
  $db->execute($sql, [$cart->id, $shop, 1]);
  header("Location: products");
}

if ($search != null) {
  $sql = $app->sqlCode->getSqlCode("searchWebshop");
  $resultset = $db->executeFetchAll($sql, [$search]);
}
?>

<!-- Page Header -->
<header class="masthead" style="background-image: url('img/wall.jpg')">
  <div class="container">
    <div class="row">
      <div class="col-lg-12 col-md-12 mx-auto">
        <div class="site-heading">
          <h1>Products</h1>
        </div>
      </div>
    </div>
  </div>
</header>

<div class="container" role="main">
  <div class="page-content">
    <div class="row">
    <div class="col-md-12">
      <br>
      <div class="row">
        <div class="col-md-6">
          <form class="" action="" method="post">
            <div id="custom-search-input">
                <div class="input-group col-md-12">
                    <input type="search" name="search" class="form-control input-lg" placeholder="Search Product" />
                    <span class="input-group-btn">
                        <button class="btn btn-info btn-lg" type="button">
                            <i class="glyphicon glyphicon-search"></i>
                        </button>
                    </span>
                </div>
            </div>
          </form>
        </div>
        <div class="col-md-6">
        </div>
        </div>
        <div class="row">
          <div class="col-md-12">
        <table class="table">
          <nav aria-label="Page navigation">
            <ul class="pagination">
              <li><a href="<?= mergeQueryString(["hits" => 2], $defaultRoute) ?>">2</a></li>
              <li><a href="<?= mergeQueryString(["hits" => 4], $defaultRoute) ?>">4</a></li>
              <li><a href="<?= mergeQueryString(["hits" => 8], $defaultRoute) ?>">8</a></li>
            </ul>
          </nav>
          <thead>
            <tr>
              <th>Bild</th>
              <th>Produkt <?= orderby("description", $defaultRoute) ?></th>
              <th>Pris <?= orderby("price", $defaultRoute) ?></th>
              <th>Kategori <?= orderby("category", $defaultRoute) ?></th>
              <th>Lagerstatus</th>
              <th></th>
            </tr>
          </thead>
          <?php foreach ($resultset as $row) :?>
            <tbody>
              <tr>
                  <td><a target="_blank" href="<?=$row->picture?>"><img src="<?= $row->picture ?>" class="img-responsive img-rounded webshop" alt="Responsive image"></a></td>
                  <td><?= $row->description ?></td>
                  <td><?= $row->price ?> kr</td>
                  <td><?= $row->category ?></td>
                  <td><?= $row->items ?> st</td>
                  <td><a type="button" class="btn btn-lg btn-primary" href="products?shop=<?= $row->id ?>"><i class="fa fa-cart-plus" aria-hidden="true"></i></a></td>
              </tr>
            </tbody>
          <?php endforeach; ?>
        </table>
        <b>Pages:</b>
        <nav aria-label="Page navigation">
          <ul class="pagination">
            <?php for ($i = 1; $i <= $max; $i++) : ?>
                <li><a href="<?= mergeQueryString(["page" => $i], $defaultRoute) ?>"><?= $i ?></a></li>
            <?php endfor; ?>
          </ul>
        </nav>
        </div>
      </div>
    </div>
  </div>
  </div>
</div>
