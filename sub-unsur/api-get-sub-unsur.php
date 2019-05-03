<?php
  session_start();
  header('Content-Type: application/json');
  
  require_once("../vendor/autoload.php");
  require("../pengaturan/medoo.php");
  require("../pengaturan/helper.php");
  
  $prepared_statement = [];
  $result = null;
  if(isset($_GET['id_unsur']))
  {
    $prepared_statement = ['id_unsur' => $_GET['id_unsur']];
    $result = $db->select("tbl_sub_unsur", "*", $prepared_statement);
  }
  else
  {
    $result = $db->select("tbl_sub_unsur", "*");
  }
  
  echo json_encode($result);
  
?>
