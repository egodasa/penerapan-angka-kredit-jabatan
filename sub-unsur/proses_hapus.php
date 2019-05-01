<?php
  session_start();
  require("../vendor/autoload.php");
  require("../pengaturan/medoo.php");
  require("../pengaturan/helper.php");
  
  if(isset($_GET['id_sub_unsur']))
  {
    $db->delete("tbl_sub_unsur", ["id_sub_unsur" => $_GET['id_sub_unsur']]);
  }
  
  // Arahkan user ke halaman unsur kembali
  header("Location: $alamat_web/sub-unsur");
?>

