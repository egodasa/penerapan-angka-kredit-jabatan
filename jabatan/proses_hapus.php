<?php
require("../pengaturan/database.php");
require("../pengaturan/helper.php");

if(isset($_GET['id_jabatan'])){
  $query = $db->prepare("DELETE FROM tbl_jabatan WHERE id_jabatan = :id_jabatan");
  $query->bindParam("id_jabatan", $_GET['id_jabatan']);
  $query->execute();
}

// Arahkan user ke halaman jabatan kembali
header("Location: $alamat_web/jabatan");
?>

