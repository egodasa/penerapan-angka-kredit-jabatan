<?php
require("../../pengaturan/database.php");
require("../../pengaturan/helper.php");

if(isset($_GET['id_usulan_unsur'])){
  $query = $db->prepare("DELETE FROM tbl_usulan_unsur WHERE id_usulan_unsur = :id_usulan_unsur");
  $query->bindParam("id_usulan_unsur", $_GET['id_usulan_unsur']);
  $query->execute();
}

// Arahkan user ke halaman unsur kembali
header("Location: $alamat_web/usulan/unsur?id_usulan=".$_GET['id_usulan']);
?>

