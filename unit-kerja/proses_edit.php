<?php
require_once("../vendor/autoload.php");
require("../pengaturan/medoo.php");
require("../pengaturan/helper.php");
if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id_unit_kerja'])){
  $db->update("tbl_unit_kerja", [
    'nm_unit_kerja' => $_POST['nm_unit_kerja'],
    'id_posisi' => $_POST['id_posisi'],
    'nip_atasan' => $_POST['nip_atasan']
  ], ["id_unit_kerja" => $_POST['id_unit_kerja']]);
}

// Arahkan unit ke halaman unit kembali
header("Location: $alamat_web/unit-kerja");
?>

