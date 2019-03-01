<?php
require("../pengaturan/database.php");
require("../pengaturan/helper.php");

if(isset($_GET['id_jabatan_jabatan_pangkat'])){
  $query = $db->prepare("DELETE FROM tbl_jabatan_pangkat WHERE id_jabatan_pangkat= :id_jabatan_pangkat");
  $query->bindParam("id_jabatan_pangkat", $_GET['id_jabatan_pangkat']);
  $query->execute();
}

// Arahkan user ke halaman pangkat kembali
header("Location: $alamat_web/kredit-pangkat");
?>

