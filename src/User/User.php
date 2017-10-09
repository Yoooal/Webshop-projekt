<?php

namespace joel\User;

use \Anax\Common\AppInjectableInterface;
use \Anax\Common\AppInjectableTrait;

class User implements AppInjectableInterface {

  use AppInjectableTrait;

  public function checkIfLoggedIn() {
      if (!$this->app->session->has("name")) {
        $this->app->response->redirect($this->app->url->create(""));
      }
  }

  public function validate($user_name, $user_pass) {
      if ($user_name != null && $user_pass != null) {
          // Check if username exists
          $sql = "SELECT * FROM Customer WHERE username LIKE ?;";
          $resultset = $this->app->db->executeFetch($sql, [$user_name]);
          $array = json_decode(json_encode($resultset), True);
          $password = $array["password"];

          // Verify user password
          if (password_verify($user_pass, $password)) {
              $this->app->session->set("name", $user_name);
              header("Location: profile");
          } else {
              header('Location: ' . $_SERVER['HTTP_REFERER']);
          }
      }
  }

  public function handleNewUser($user_name, $user_pass, $re_user_pass, $firstName, $lastName) {
      if ($user_pass == $re_user_pass) {
          $crypt_pass = password_hash($user_pass, PASSWORD_DEFAULT);
          $sql = "INSERT INTO Customer (username, password, firstName, lastName) VALUES (?, ?, ?, ?);";
          $this->app->db->execute($sql, [$user_name, $crypt_pass, $firstName, $lastName]);
          $usersId = $this->app->db->lastInsertId();
          $sql = "CALL createVarukorg(?)";
          $this->app->db->execute($sql, [$usersId]);
          header('Location: ' . $_SERVER['HTTP_REFERER']);
      }
  }

  public function showCart() {
    $costumerName = $this->app->session->get("name");
    $sql = "SELECT id FROM Customer WHERE username = ?;";
    $customer = $this->app->db->executeFetch($sql, [$costumerName]);
    $sql = "SELECT * FROM Varukorg WHERE customer = ?;";
    $cart = $this->app->db->executeFetch($sql, [$customer->id]);
    $sql = $this->app->sqlCode->getSqlCode("showCart");
    $resultset = $this->app->db->executeFetchAll($sql, [$cart->id]);
    return $resultset;
  }

  public function shopProduct($shop) {
    $costumerName = $this->app->session->get("name");
    $sql = "SELECT id FROM Customer WHERE username = ?;";
    $customer = $this->app->db->executeFetch($sql, [$costumerName]);
    $sql = "SELECT * FROM Varukorg WHERE customer = ?;";
    $cart = $this->app->db->executeFetch($sql, [$customer->id]);
    $sql = "CALL addToVarukorg(?, ?, ?);";
    $this->app->db->execute($sql, [$cart->id, $shop, 1]);
    header("Location: products");
  }

  public function logout() {
      if ($this->app->session->has("name")) {
          $this->app->session->destroy();
          $this->app->response->redirect($this->app->url->create(""));
      } else {
        $this->app->response->redirect($this->app->url->create(""));
      }
  }



}
