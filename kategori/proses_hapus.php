<?php
require("../pengaturan/database.php");
require("../pengaturan/helper.php");

if(isset($_GET['id_kategori'])){
  $query = $db->prepare("DELETE FROM tbl_kategori WHERE id_kategori = :id_kategori");
  $query->bindParam("id_kategori", $_GET['id_kategori']);
  $query->execute();
}

// Arahkan user ke halaman kategori kembali
header("Location: $alamat_web/kategori");
?>

