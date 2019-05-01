<?php
  session_start();
  require("../vendor/autoload.php");
  require("../pengaturan/medoo.php");
  require("../pengaturan/helper.php");
  if($_SERVER['REQUEST_METHOD'] == 'POST')
  {
    $db->update("tbl_unsur", ["nm_unsur" => $_POST['nm_unsur']], ["id_unsur" => $_POST['id_unsur']]);
  }

  // Arahkan user ke halaman unsur kembali
  header("Location: $alamat_web/unsur");
?>

