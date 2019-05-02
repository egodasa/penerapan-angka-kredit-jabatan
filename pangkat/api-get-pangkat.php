<?php
  session_start();
  header('Content-Type: application/json');
  
  require_once("../vendor/autoload.php");
  require("../pengaturan/medoo.php");
  require("../pengaturan/helper.php");
  
  $prepared_statement = [];
  $result = null;
  if(isset($_GET['id_jabatan']))
  {
    $prepared_statement = ['id_jabatan' => $_GET['id_jabatan']];
    $result = $db->select("tbl_pangkat", "*", $prepared_statement);
  }
  else
  {
    $result = $db->select("tbl_pangkat", "*");
  }
  
  echo json_encode($result);
  
?>
