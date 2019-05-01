<?php
require_once("../../vendor/autoload.php");
require("../../pengaturan/medoo.php");
require("../../pengaturan/helper.php");

$hasil = [];

$hasil = $db->select("tbl_butir_kegiatan", "*", ["id_sub_unsur" => $_GET['id_sub_unsur']]);

echo json_encode($hasil);
?>

