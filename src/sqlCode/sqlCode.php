<?php

namespace joel\sqlCode;


class sqlCode
{

  public function getSqlCode($action) {
    switch($action) {

      case "pages":
        $sql = <<<EOD
        SELECT
        *,
        CASE
            WHEN (deleted <= NOW()) THEN "isDeleted"
            WHEN (published <= NOW()) THEN "isPublished"
            ELSE "notPublished"
        END AS status
        FROM content
        WHERE type=?
        ;
EOD;
      break;

      case "page":
        $sql = <<<EOD
        SELECT
        *,
        DATE_FORMAT(COALESCE(updated, published), '%Y-%m-%dT%TZ') AS modified_iso8601,
        DATE_FORMAT(COALESCE(updated, published), '%Y-%m-%d') AS modified
        FROM content
        WHERE
        path = ?
        AND type = ?
        AND (deleted IS NULL OR deleted > NOW())
        AND published <= NOW()
        ;
EOD;
      break;

      case "blogpost":
        $sql = <<<EOD
        SELECT
        *,
        DATE_FORMAT(COALESCE(updated, published), '%Y-%m-%dT%TZ') AS published_iso8601,
        DATE_FORMAT(COALESCE(updated, published), '%Y-%m-%d') AS published
        FROM content
        WHERE
        slug = ?
        AND type = ?
        AND (deleted IS NULL OR deleted > NOW())
        AND published <= NOW()
        ORDER BY published DESC
        ;
EOD;
      break;

      case "blog":
        $sql = <<<EOD
        SELECT
        *,
        DATE_FORMAT(COALESCE(updated, published), '%Y-%m-%dT%TZ') AS published_iso8601,
        DATE_FORMAT(COALESCE(updated, published), '%Y-%m-%d') AS published
        FROM content
        WHERE type=?
        ORDER BY published DESC
        ;
EOD;
      break;

      case "showWebshop":
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
        ;
EOD;
      break;

      case "showWebshop":
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
        ;
EOD;
      break;

      case "searchWebshop":
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
        WHERE P.description LIKE ?
        ;
EOD;
      break;

      case "editWebshop":
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
        WHERE P.id = ?
        GROUP BY P.id
        ;
EOD;
      break;

      case "updateCategory":
        $sql = <<<EOD
        UPDATE
        Product
      	INNER JOIN Prod2Cat
      		ON Product.id = Prod2Cat.prod_id
      	INNER JOIN ProdCategory
      		ON ProdCategory.id = Prod2Cat.cat_id
        SET category=?
        WHERE Product.id = ?
        ;
EOD;
      break;

      case "showNews":
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
        ORDER BY id DESC LIMIT 4;
EOD;
      break;

      case "showCart":
        $sql = <<<EOD
        SELECT
        	V.id,
        	V.varukorg,
        	P.picture,
        	V.product,
        	P.description,
        	P.price,
        	V.items,
        	GROUP_CONCAT(category) AS category
        FROM VarukorgRow AS V
        	INNER JOIN Product AS P
        		ON P.id = V.product
        	INNER JOIN Prod2Cat AS P2C
        		ON P.id = P2C.prod_id
        	INNER JOIN ProdCategory AS PC
        		ON PC.id = P2C.cat_id
        WHERE varukorg = ?
        GROUP BY V.id
        ;
EOD;
      break;

      case "showOrder":
        $sql = <<<EOD
        SELECT
        	R.id,
        	R.order,
        	C.id AS customer,
        	C.firstName,
        	C.lastName,
        	P.picture,
        	R.product,
        	P.description,
        	P.price,
        	R.items,
        	GROUP_CONCAT(category) AS category
        	FROM OrderRow AS R
          INNER JOIN `Order` AS O
        		ON O.id = R.order
          INNER JOIN Customer AS C
        		ON C.id = O.customer
        	INNER JOIN Product AS P
        		ON P.id = R.product
        	INNER JOIN Prod2Cat AS P2C
        		ON P.id = P2C.prod_id
        	INNER JOIN ProdCategory AS PC
        		ON PC.id = P2C.cat_id
        WHERE customer = ?
        GROUP BY R.id
        ;
EOD;
      break;

      case "block":
        $sql = <<<EOD
        SELECT
        *
        FROM content
        WHERE
        path = ?
        AND type = ?
        AND (deleted IS NULL OR deleted > NOW())
        AND published <= NOW()
        ;
EOD;
      break;

      default:
      die("Error message.");
    }
    return $sql;
  }

}
