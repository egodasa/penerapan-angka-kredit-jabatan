<?php
require_once("../vendor/autoload.php");
require("../pengaturan/medoo.php");
require("../pengaturan/helper.php");
header('Content-Type:application/json');

$jabatan_pangkat = $db->query("SELECT a.*, b.nm_pangkat FROM tbl_jabatan_pangkat a JOIN tbl_pangkat b ON a.id_pangkat = b.id_pangkat WHERE a.id_jabatan = :id_jabatan ", ['id_jabatan' => $_GET['id_jabatan']])->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($jabatan_pangkat);
?>

