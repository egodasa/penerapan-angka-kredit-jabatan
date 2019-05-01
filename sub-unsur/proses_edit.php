<?php
  session_start();
  require("../vendor/autoload.php");
  require("../pengaturan/medoo.php");
  require("../pengaturan/helper.php");
  if($_SERVER['REQUEST_METHOD'] == 'POST')
  {
    $db->update("tbl_sub_unsur", ["nm_sub_unsur" => $_POST['nm_sub_unsur']], ["id_sub_unsur" => $_POST['id_sub_unsur']]);
  }

  // Arahkan user ke halaman unsur kembali
  header("Location: $alamat_web/sub-unsur");
?>

