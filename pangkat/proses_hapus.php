<?php
require("../pengaturan/database.php");
require("../pengaturan/helper.php");

if(isset($_GET['id_pangkat'])){
  $query = $db->prepare("DELETE FROM tbl_pangkat WHERE id_pangkat = :id_pangkat");
  $query->bindParam("id_pangkat", $_GET['id_pangkat']);
  $query->execute();
}

// Arahkan user ke halaman pangkat kembali
header("Location: $alamat_web/pangkat");
?>

