<?php
require("../pengaturan/database.php");
require("../pengaturan/helper.php");
if($_SERVER['REQUEST_METHOD'] == 'POST'){
  $query = $db->prepare("INSERT INTO tbl_jabatan (nm_jabatan) VALUES (?)");
  $query->bindParam(1, $_POST['nm_jabatan']);
  $query->execute();
}

// Arahkan user ke halaman jabatan kembali
header("Location: $alamat_web/jabatan");
?>

