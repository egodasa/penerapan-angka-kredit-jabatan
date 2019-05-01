<?php
  require_once("../vendor/autoload.php");
  require("../pengaturan/medoo.php");
  require("../pengaturan/helper.php");
  
  if(isset($_GET['id_posisi'])){
    $db->delete("tbl_posisi", ["id_posisi" => $_GET['id_posisi']]);
  }
  
  // Arahkan posisi ke halaman posisi kembali
  header("Location: $alamat_web/posisi");
?>

