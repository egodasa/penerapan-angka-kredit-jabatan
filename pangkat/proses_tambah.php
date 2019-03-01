<?php
require("../pengaturan/database.php");
require("../pengaturan/helper.php");
if($_SERVER['REQUEST_METHOD'] == 'POST'){
  $query = $db->prepare("INSERT INTO tbl_pangkat (nm_pangkat) VALUES (?)");
  $query->bindParam(1, $_POST['nm_pangkat']);
  $query->execute();
}

// Arahkan user ke halaman pangkat kembali
header("Location: $alamat_web/pangkat");
?>

