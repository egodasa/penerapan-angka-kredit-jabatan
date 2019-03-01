<?php
require("../pengaturan/database.php");
require("../pengaturan/helper.php");

if(isset($_GET['id_berkas'])){
  $query = $db->prepare("DELETE FROM tbl_jenis_berkas WHERE id_berkas = :id_berkas");
  $query->bindParam("id_berkas", $_GET['id_berkas']);
  $query->execute();
}

// Arahkan user ke halaman jenis berkas kembali
header("Location: $alamat_web/jenis-berkas");
?>

