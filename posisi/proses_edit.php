<?php
  ini_set('display_errors','off');
  require_once("../vendor/autoload.php");
  require("../pengaturan/medoo.php");
  require("../pengaturan/helper.php");
  if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id_posisi'])){
    $db->update("tbl_posisi", [
      'nm_posisi' => $_POST['nm_posisi'],
      'jenis_posisi' => $_POST['jenis_posisi'],
    ],["id_posisi" => $_POST['id_posisi']]);
  }
  
  // Arahkan posisi ke halaman posisi kembali
  header("Location: $alamat_web/posisi");
?>

