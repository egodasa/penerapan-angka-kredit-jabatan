<?php
require("../pengaturan/database.php");
require("../pengaturan/helper.php");
if($_SERVER['REQUEST_METHOD'] == 'POST'){
  $query = $db->prepare("INSERT INTO tbl_meja (nm_meja, kd_meja) VALUES (?, ?)");
  $query->bindParam(1, $_POST['nm_meja']);
  $query->bindParam(2, $_POST['kd_meja']);
  $query->execute();
}

// Arahkan user ke halaman meja kembali
header("Location: $alamat_web/meja");
?>

