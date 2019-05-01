<?php
  session_start();
  require("../vendor/autoload.php");
  require("../pengaturan/medoo.php");
  require("../pengaturan/helper.php");

  if(isset($_GET['id_butir']))
  {
    $db->delete("tbl_butir_kegiatan", ["id_butir" => $_GET['id_butir']]);
  }
  
  // Arahkan posisi ke halaman posisi kembali
  header("Location: $alamat_web/butir-kegiatan");
?>

