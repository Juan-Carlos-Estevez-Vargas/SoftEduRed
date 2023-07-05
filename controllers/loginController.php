<?php
  require_once "../services/loginService.php";

  $new = new LoginService();
  $new->loginUser($_POST["username"], $_POST["password"]);
?>