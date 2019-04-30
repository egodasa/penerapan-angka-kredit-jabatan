<?php
require_once("../../vendor/autoload.php");
require("../../pengaturan/medoo.php");
require("../../pengaturan/helper.php");

if(isset($_GET['id_butir'])){
  $db->delete("tbl_butir_kegiatan", ["id_butir" => $_GET['id_butir']]);
}

// Arahkan posisi ke halaman posisi kembali
header("Location: $alamat_web/unsur-kegiatan/butir-kegiatan/index.php?id_sub_unsur=".$_GET['id_sub_unsur']);
?>

