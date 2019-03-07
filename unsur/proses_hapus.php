<?php
require_once("../vendor/autoload.php");
require("../pengaturan/medoo.php");
require("../pengaturan/helper.php");

if(isset($_GET['id_unsur'])){
  $db->delete("tbl_unsur", ["id_unsur" => $_GET['id_unsur']]);
}

// Arahkan posisi ke halaman posisi kembali
header("Location: $alamat_web/unsur");
?>

