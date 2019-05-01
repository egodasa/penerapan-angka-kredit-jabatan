<?php
  session_start();
  header('Content-Type: application/json');
  
  require_once("../vendor/autoload.php");
  require("../pengaturan/medoo.php");
  require("../pengaturan/helper.php");
  
  $prepared_statement = [];
  $result = null;
  if(isset($_GET['id_posisi']))
  {
    $prepared_statement = ['id_posisi' => $_GET['id_posisi']];
    $result = $db->get("tbl_posisi", "*", $prepared_statement);
  }
  else
  {
    $result = $db->select("tbl_posisi", "*");
  }
  
  echo json_encode($result);
  
?>
