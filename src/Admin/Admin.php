<?php

namespace joel\Admin;

use \Anax\Common\AppInjectableInterface;
use \Anax\Common\AppInjectableTrait;

class Admin implements AppInjectableInterface {

  use AppInjectableTrait;

  public function checkIfAdmin() {
    if ($this->app->session->get("name") != "admin") {
      $this->app->response->redirect($this->app->url->create(""));
    }
  }

  public function createContent($title) {
    $sql = "INSERT INTO content (title) VALUES (?);";
    $this->app->db->execute($sql, [$title]);
    $id = $this->app->db->lastInsertId();
    header("Location: edit?id=$id");
  }

  public function deleteContent($contentId) {
    $sql = "UPDATE content SET deleted=NOW() WHERE id=?;";
    $this->app->db->execute($sql, [$contentId]);
    header("Location: content");
  }

  public function updateContent($params) {
    if (!$params["contentPath"]) {
    $params["contentPath"] = null;
    }
    if (!$params["contentSlug"]) {
        $params["contentSlug"] = slugify($params["contentTitle"]);
    }
    $sql = "UPDATE content SET title=?, path=?, slug=?, data=?, type=?, filter=?, published=? WHERE id = ?;";
    $this->app->db->execute($sql, array_values($params));
  }

  public function updateWebshop($params) {
    $sql = "UPDATE Product SET description=?, picture=?, price=? WHERE id = ?;";
    $this->app->db->execute($sql, [$params["description"], $params["picture"], $params["price"], $params["id"]]);
    $category = substr($params["category"],0,1);
    $sql = "UPDATE Prod2Cat SET cat_id=? WHERE prod_id = ?;";
    $this->app->db->execute($sql, [$category, $params["id"]]);
    $sql = "UPDATE Inventory SET items=? WHERE prod_id = ?;";
    $this->app->db->execute($sql, [$params["items"], $params["id"]]);
  }

  public function createWebshop($params) {
    $sql = "INSERT INTO Product (description, picture, price) VALUES (?, ?, ?);";
    $this->app->db->execute($sql, [$params["description"], $params["picture"], $params["price"]]);
    $id = $this->app->db->lastInsertId();
    $sql = "INSERT INTO Prod2Cat (prod_id, cat_id) VALUES (?, ?);";
    $this->app->db->execute($sql, [$id, $params["category"]]);
    $sql = "INSERT INTO Inventory (prod_id, shelf_id, items) VALUES (?, ?, ?);";
    $this->app->db->execute($sql, [$id, "AAA102", $params["items"]]);
    header('Location: ' . $_SERVER['REDIRECT_URL']);
  }



}
