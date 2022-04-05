<?php
  include("db.php");
  global $link;
  try {
    $link = new PDO("mysql:host=$host;dbname=$dbname; charset=$charset", $dbusr, $dbpwd);
    $link->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  } catch (Exception $e) {
    die("Unable to connect: " . $e->getMessage());
  }

?>