<?php
require_once("../../vendor/autoload.php");
require("../../pengaturan/medoo.php");
require("../../pengaturan/helper.php");

if(isset($_GET['id_sub_unsur'])){
  $db->delete("tbl_sub_unsur", ["id_sub_unsur" => $_GET['id_sub_unsur']]);
}

// Arahkan posisi ke halaman posisi kembali
header("Location: $alamat_web/unsur/sub-unsur?id_unsur=".$_POST['id_unsur']);
?>

