<?php
require("../pengaturan/database.php");
require("../pengaturan/helper.php");

if(isset($_GET['id_usulan'])){
  $query = $db->prepare("DELETE FROM tbl_usulan WHERE id_usulan = :id_usulan");
  $query->bindParam("id_usulan", $_GET['id_usulan']);
  $query->execute();
}

// Arahkan user ke halaman usulan kembali
header("Location: $alamat_web/usulan");
?>

