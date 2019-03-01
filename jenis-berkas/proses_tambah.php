<?php
require("../pengaturan/database.php");
require("../pengaturan/helper.php");
if($_SERVER['REQUEST_METHOD'] == 'POST'){
  $query = $db->prepare("INSERT INTO tbl_jenis_berkas (nm_berkas) VALUES (?)");
  $query->bindParam(1, $_POST['nm_berkas']);
  $query->execute();
}

// Arahkan user ke halaman jenis berkas kembali
header("Location: $alamat_web/jenis-berkas");
?>

