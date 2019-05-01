<?php
  session_start();
  require("../vendor/autoload.php");
  require("../pengaturan/medoo.php");
  require("../pengaturan/helper.php");

  if(isset($_GET['id_pangkat']))
  {
    $db->delete("tbl_pangkat", ["id_pangkat" => $_GET['id_pangkat']]);
  }
  
  // Arahkan user ke halaman pangkat kembali
  header("Location: $alamat_web/pangkat");
?>

