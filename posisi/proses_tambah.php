<?php
require_once("../vendor/autoload.php");
require("../pengaturan/medoo.php");
require("../pengaturan/helper.php");
if($_SERVER['REQUEST_METHOD'] == 'POST'){
  $db->insert("tbl_posisi", [
    'nm_posisi' => $_POST['nm_posisi'],
    'jenis_posisi' => $_POST['jenis_posisi'],
  ]);
}

// Arahkan posisi ke halaman posisi kembali
header("Location: $alamat_web/posisi");
?>

