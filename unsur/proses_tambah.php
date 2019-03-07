<?php
require_once("../vendor/autoload.php");
require("../pengaturan/medoo.php");
require("../pengaturan/helper.php");
if($_SERVER['REQUEST_METHOD'] == 'POST'){
  $db->insert("tbl_unsur", [
    'nm_unsur' => $_POST['nm_unsur']
  ]);
}

// Arahkan posisi ke halaman posisi kembali
header("Location: $alamat_web/unsur");
?>

