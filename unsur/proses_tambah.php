<?php
require("../pengaturan/database.php");
require("../pengaturan/helper.php");
if($_SERVER['REQUEST_METHOD'] == 'POST'){
  $query = $db->prepare("INSERT INTO tbl_unsur (nm_unsur) VALUES (?)");
  $query->bindParam(1, $_POST['nm_unsur']);
  $query->execute();
}

// Arahkan user ke halaman unsur kembali
header("Location: $alamat_web/unsur");
?>

