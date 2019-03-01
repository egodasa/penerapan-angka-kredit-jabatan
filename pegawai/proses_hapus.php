<?php
require_once("../vendor/autoload.php");
require("../pengaturan/medoo.php");
require("../pengaturan/helper.php");

if(isset($_GET['id_pegawai'])){
  $db->delete("tbl_pegawai", ["id_pegawai" => $_GET['id_pegawai']]);
}

// Arahkan pegawai ke halaman pegawai kembali
header("Location: $alamat_web/pegawai");
?>

