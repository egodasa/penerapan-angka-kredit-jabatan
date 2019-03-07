<?php
require_once("../../vendor/autoload.php");
require("../../pengaturan/medoo.php");
require("../../pengaturan/helper.php");
if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id_sub_unsur'])){
  $db->update("tbl_sub_unsur", [
    'nm_unsur' => $_POST['nm_unsur'],
    'id_posisi' => $_POST['id_posisi'],
    'jenis_unsur' => $_POST['jenis_unsur']
  ],
  [
    "id_sub_unsur" => $_POST['id_sub_unsur']
  ]);
}

// Arahkan posisi ke halaman posisi kembali
header("Location: $alamat_web/unsur/sub-unsur?id_unsur=".$_POST['id_unsur']);
?>

