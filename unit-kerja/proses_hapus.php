<?php
require_once("../vendor/autoload.php");
require("../pengaturan/medoo.php");
require("../pengaturan/helper.php");

if(isset($_GET['id_unit_kerja'])){
  $db->delete("tbl_unit_kerja", ["id_unit_kerja" => $_GET['id_unit_kerja']]);
}

// Arahkan unit ke halaman unit kembali
header("Location: $alamat_web/unit-kerja");
?>

