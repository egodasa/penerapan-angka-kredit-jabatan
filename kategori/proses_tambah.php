<?php
require("../pengaturan/database.php");
require("../pengaturan/helper.php");
if($_SERVER['REQUEST_METHOD'] == 'POST'){
  $query = $db->prepare("INSERT INTO tbl_kategori (nm_kategori) VALUES (?)");
  $query->bindParam(1, $_POST['nm_kategori']);
  $query->execute();
}

// Arahkan user ke halaman kategori kembali
header("Location: $alamat_web/kategori");
?>

