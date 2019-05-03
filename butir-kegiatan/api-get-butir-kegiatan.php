<?php
  session_start();
  header('Content-Type: application/json');
  
  require_once("../vendor/autoload.php");
  require("../pengaturan/medoo.php");
  require("../pengaturan/helper.php");
  
  $prepared_statement = [];
  $result = null;
  if(isset($_GET['id_sub_unsur']))
  {
    $prepared_statement = ['id_sub_unsur' => $_GET['id_sub_unsur']];
    $result = $db->select("tbl_butir_kegiatan", "*", $prepared_statement);
  }
  else
  {
    $result = $db->select("tbl_butir_kegiatan", "*");
  }
  
  echo json_encode($result);
  
?>
