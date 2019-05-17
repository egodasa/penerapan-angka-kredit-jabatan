<?php
require_once("../vendor/autoload.php");
require("../pengaturan/medoo.php");
require("../pengaturan/helper.php");
header('Content-Type:application/json');

if(isset($_GET['id_posisi']) && !empty($_GET['id_posisi']))
{
  $pegawai = $db->select("tbl_pegawai", "*", ["id_posisi" => $_GET['id_posisi']]);
  echo json_encode($pegawai);
  exit;
}

$pegawai = $db->select("tbl_pegawai", "*");

echo json_encode($pegawai);
?>

